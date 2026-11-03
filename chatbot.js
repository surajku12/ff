/* chatbot.js */
const chatbotData = {
    states: {
        start: {
            message: "Hi! I'm your Kash Style Assistant. 👋 I can help you find the perfect outfit! Who are we shopping for today?",
            options: [
                { label: "Men", value: "men", next: "category" },
                { label: "Women", value: "women", next: "category" },
                { label: "Kids", value: "kids", next: "category" }
            ]
        },
        category: {
            message: (selection) => `Awesome selection! What type of ${selection.gender} wear are you looking for?`,
            options: (selection) => {
                // Get unique categories from products based on gender selection
                const gender = selection.gender;
                const relevantProducts = Object.values(products).filter(p => p.category && p.category.toLowerCase().trim() === gender.toLowerCase().trim());
                const categories = [...new Set(relevantProducts.map(p => p.subCategory).filter(Boolean))].sort();
                
                return [
                    ...categories.map(cat => ({ label: cat, value: cat, next: "color" })),
                    { label: "Browse All", value: "all", next: "color" }
                ];
            }
        },
        color: {
            message: "Got it! Any specific color preference, or should I show you the best of everything?",
            options: (selection) => {
                const gender = selection.gender;
                const subCat = selection.category;
                let relevant = Object.values(products).filter(p => p.category && p.category.toLowerCase().trim() === gender.toLowerCase().trim());
                if(subCat && subCat !== 'all') {
                    relevant = relevant.filter(p => p.subCategory && p.subCategory.toLowerCase().trim() === subCat.toLowerCase().trim());
                }
                const colors = [...new Set(relevant.map(p => p.color).filter(Boolean))].sort().slice(0, 5); // top 5 colors
                
                return [
                    ...colors.map(c => ({ label: c, value: c, next: "result" })),
                    { label: "Surprise Me!", value: "any", next: "result" }
                ];
            }
        },
        result: {
            message: "I've picked out some items I think you'll love! Take a look below: ✨",
            process: (selection) => {
                const { gender, category, color } = selection;
                console.log("Chatbot Filtering with:", selection);
                
                let results = Object.values(products).filter(p => 
                    p.category && p.category.toLowerCase().trim() === gender.toLowerCase().trim()
                );
                
                if (category && category !== 'all') {
                    results = results.filter(p => 
                        p.subCategory && p.subCategory.toLowerCase().trim() === category.toLowerCase().trim()
                    );
                }
                
                if (color && color !== 'any') {
                    results = results.filter(p => 
                        p.color && p.color.toLowerCase().trim() === color.toLowerCase().trim()
                    );
                }
                
                console.log("Chatbot Found matches:", results.length);
                return results.slice(0, 5); // Top 5 matches
            }
        }
    }
};

class KashChatbot {
    constructor() {
        this.container = null;
        this.messagesEnd = null;
        this.input = null;
        this.history = [];
        this.selection = {
            gender: null,
            category: null,
            color: null
        };
        this.currentState = 'start';
        this.isOpen = false;
        
        this.init();
    }

    init() {
        // Wait for products to load (from script.js)
        if (typeof products === 'undefined') {
            setTimeout(() => this.init(), 100);
            return;
        }
        
        this.render();
        this.attachEvents();
    }

    render() {
        this.container = document.getElementById('chatbot-messages');
        this.messagesEnd = document.getElementById('chat-anchor');
        this.optionsContainer = document.getElementById('quick-replies');
        
        if (this.history.length === 0) {
            this.goToState('start');
        }
    }

    attachEvents() {
        const trigger = document.getElementById('chatbot-trigger');
        const window = document.getElementById('chatbot-window');
        
        // Input logic
        this.input = document.getElementById('chat-text-input');
        const sendBtn = document.getElementById('chat-send-btn');
        
        trigger.addEventListener('click', () => {
            this.isOpen = !this.isOpen;
            trigger.classList.toggle('active');
            window.classList.toggle('active');
            
            if (this.isOpen && this.history.length === 0) {
                this.goToState('start');
            }
        });

        const handleSend = () => {
            const text = this.input.value.trim();
            if (text) {
                this.handleTextInput(text);
                this.input.value = '';
            }
        };

        sendBtn.addEventListener('click', handleSend);
        this.input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') handleSend();
        });
    }

    async handleTextInput(text) {
        // Show user message
        this.addMessage(text, 'user');
        
        // Hide standard options while searching
        this.optionsContainer.innerHTML = '';
        
        const typing = this.showTyping();
        await new Promise(r => setTimeout(r, 600));
        typing.remove();

        const lowerText = text.toLowerCase();
        
        // Very basic Keyword extraction
        let foundGender = null;
        let foundCategory = null;
        let foundColor = null;

        // Extract Gender
        ['men', 'women', 'kids', 'boy', 'girl'].forEach(g => {
            if (lowerText.includes(g)) foundGender = g === 'boy' ? 'kids' : g === 'girl' ? 'kids' : g;
        });

        // Search through all products to find matching categories/colors in the text
        let potentialMatches = Object.values(products);
        
        if (foundGender) {
            potentialMatches = potentialMatches.filter(p => p.category && p.category.toLowerCase() === foundGender);
        }

        // Extremely generous text search across name, category, and color
        const keywords = lowerText.split(/\s+/).filter(w => w.length > 2); // Ignore short words like "a", "in"

        if (keywords.length > 0) {
           potentialMatches = potentialMatches.filter(p => {
               const searchString = `${p.name} ${p.subCategory} ${p.color} ${p.category}`.toLowerCase();
               // At least one significant keyword must match
               return keywords.some(kw => searchString.includes(kw));
           });
        }

        if (potentialMatches.length > 0) {
            this.addMessage("Here's what I found based on your request:");
            this.showRecommendations(potentialMatches.slice(0, 5));
        } else {
            this.addMessage("I'm sorry, I couldn't find exactly what you're looking for based on that search. Let's try the step-by-step way!");
            this.goToState('start');
        }

        // Always offer reset after custom search
        setTimeout(() => {
            const btn = document.createElement('button');
            btn.className = 'reply-btn';
            btn.innerText = "Start Over 🔄";
            btn.onclick = () => {
                this.selection = { gender: null, category: null, color: null };
                this.container.innerHTML = '<div id="chat-anchor"></div>';
                this.history = [];
                this.goToState('start');
            };
            this.optionsContainer.appendChild(btn);
        }, 1000);
    }


    addMessage(text, sender = 'assistant') {
        const msgDiv = document.createElement('div');
        msgDiv.className = `message ${sender}`;
        msgDiv.innerHTML = text;
        this.container.appendChild(msgDiv);
        this.scrollToBottom();
        this.history.push({ text, sender });
    }

    showTyping() {
        const typingDiv = document.createElement('div');
        typingDiv.className = 'message assistant typing';
        typingDiv.id = 'chat-typing';
        typingDiv.innerHTML = '<span></span><span></span><span></span>';
        this.container.appendChild(typingDiv);
        this.scrollToBottom();
        return typingDiv;
    }

    scrollToBottom() {
        requestAnimationFrame(() => {
            this.container.scrollTop = this.container.scrollHeight;
        });
    }

    async goToState(stateKey) {
        this.currentState = stateKey;
        const config = chatbotData.states[stateKey];
        
        // Hide options
        this.optionsContainer.innerHTML = '';
        
        // Typing indicator
        const typing = this.showTyping();
        await new Promise(r => setTimeout(r, 800));
        typing.remove();

        const messageText = typeof config.message === 'function' ? config.message(this.selection) : config.message;
        this.addMessage(messageText);

        if (stateKey === 'result') {
            const matches = config.process(this.selection);
            this.showRecommendations(matches);
            
            // Allow resetting
            setTimeout(() => {
                this.showQuickReplies([{ label: "Start Over 🔄", value: "reset", next: "start" }]);
            }, 1000);
            return;
        }

        const options = typeof config.options === 'function' ? config.options(this.selection) : config.options;
        this.showQuickReplies(options);
    }

    showQuickReplies(options) {
        this.optionsContainer.innerHTML = '';
        options.forEach(opt => {
            const btn = document.createElement('button');
            btn.className = 'reply-btn';
            btn.innerText = opt.label;
            btn.onclick = () => this.handleSelection(opt);
            this.optionsContainer.appendChild(btn);
        });
    }

    handleSelection(opt) {
        if (opt.value === 'reset') {
            this.selection = { gender: null, category: null, color: null };
            this.container.innerHTML = '<div id="chat-anchor"></div>';
            this.history = [];
            this.goToState('start');
            return;
        }

        this.addMessage(opt.label, 'user');
        
        // Save selection based on current state
        if (this.currentState === 'start') this.selection.gender = opt.value;
        else if (this.currentState === 'category') this.selection.category = opt.value;
        else if (this.currentState === 'color') this.selection.color = opt.value;
        
        this.goToState(opt.next);
    }

    showRecommendations(matches) {
        console.log("Rendering recommendations:", matches);
        if (!Array.isArray(matches) || matches.length === 0) {
            this.addMessage("I couldn't find exact matches for that specific combination. Let me show you some popular items instead:");
            // Safe Fallback: if no gender is selected, show general popular items.
            const fallbackGender = this.selection.gender || 'men'; 
            matches = Object.values(products).filter(p => 
                p.category && p.category.toLowerCase().trim() === fallbackGender.toLowerCase().trim()
            ).slice(0, 3);
        }

        const scroller = document.createElement('div');
        scroller.className = 'recommendation-scroller';
        
        matches.forEach(p => {
            if (!p) return;
            const card = document.createElement('div');
            card.className = 'chat-product-card';
            card.innerHTML = `
                <img src="${p.image}" alt="${p.name}" onerror="this.src='https://via.placeholder.com/300x400?text=Product+Image'">
                <div class="chat-product-info">
                    <h4>${p.name}</h4>
                    <p>₹${p.price}</p>
                    <a href="product-details.php?id=${p.id}" target="_blank">View Details</a>
                </div>
            `;
            scroller.appendChild(card);
        });
        
        this.container.appendChild(scroller);
        this.scrollToBottom();
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.kashBot = new KashChatbot();
});
