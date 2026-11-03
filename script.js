window.addEventListener('error', function (event) {
    console.error('Global JS error:', event.message, 'at', event.filename + ':' + event.lineno + ':' + event.colno);
});
window.addEventListener('unhandledrejection', function (event) {
    console.error('Unhandled promise rejection:', event.reason);
});

// ========== PRODUCT DATABASE ==========
const products = {
    1: { id: 1, name: "LEATHER EFFECT JACKET WITH DETACHABLE COLLAR", category: "Men", subCategory: "Jacket", color: "Black", price: 2500, image: "images/LEATHER EFFECT JACKET WITH DETACHABLE COLLAR.jpg", description: "A timeless vintage-inspired denim jacket perfect for any casual outfit. Made with high-quality denim fabric, offering comfort and durability. Great layering piece for spring and fall.", sizes: ["S", "M", "L", "XL", "XXL"] },
    2: { id: 2, name: "HEAVYWEIGHT BASIC HOODIE", category: "Men", subCategory: "Hoodie", color: "Black", price: 890, image: "images/HEAVYWEIGHT BASIC HOODIE.jpg", description: "Professional and elegant slim-fit blazer suited for business meetings and formal events. Crafted with premium fabric for a polished look. Perfect for creating sharp, sophisticated outfits.", sizes: ["S", "M", "L", "XL", "XXL"] },
    3: { id: 3, name: "Nuon Beige Cargo Pants", category: "Men", subCategory: "Pants", color: "Beige", price: 450, image: "images/Nuon Beige Cargo-Style Relaxed-Fit Mid-Rise Cotton Pants.webp", description: "Luxurious silk evening gown designed for special occasions. Features elegant draping and a flattering silhouette. Ideal for formal dinners, galas, and evening events.", sizes: ["S", "M", "L", "XL", "XXL"] },
    4: { id: 4, name: "Women High-Rise Relaxed Jeans", category: "Women", subCategory: "Jeans", color: "Blue", price: 650, image: "women/girl1.avif", description: "Premium Women High-Rise Relaxed Jeans for party occasions. Well-tailored with perfect fit and finish. A versatile wardrobe staple for the modern women.", sizes: ["S", "M", "L", "XL", "XXL"] },
    5: { id: 5, name: "Women Wide-Leg Denim Jeans", category: "Women", subCategory: "Jeans", color: "Blue", price: 1200, image: "women/Women Wide-Leg Denim Jeans.avif", description: "Contemporary denim Jeans with a modern urban style. Features quality stitching and comfortable fit. Perfect for casual everyday wear.", sizes: ["S", "M", "L", "XL", "XXL"] },
    6: { id: 6, name: "Nuon Red Printed T-Shirt", category: "Men", subCategory: "T-Shirt", color: "Red", price: 650, image: "images/Nuon Red Printed Relaxed-Fit Cotton T-Shirt.webp", description: "Classic oxford shirt in a timeless design. Made with breathable fabric for all-day comfort. Versatile piece that works for both casual and semi-formal settings.", sizes: ["S", "M", "L", "XL", "XXL"] },
    7: { id: 7, name: "Nuon Red Striped Polo T-Shirt", category: "Men", subCategory: "T-Shirt", color: "Red", price: 550, image: "images/Nuon Red Striped Relaxed-Fit Cotton Polo T-Shirt.webp", description: "Fun and comfortable Polo T-Shirt overalls for men . Features adjustable straps and durable Tshirt construction. Perfect for casual outings.", sizes: ["S", "M", "L", "XL", "XXL"] },
    8: { id: 8, name: "Women Loose Fit Pull-On Jeans", category: "Women", subCategory: "Jeans", color: "Blue", price: 450, image: "women/Women Loose Fit Pull-On Jeans.avif", description: "Premium Women Loose Fit Pull-On Jeans for everyday wear. Well-tailored with perfect fit and finish. A versatile wardrobe staple for the modern women.", sizes: ["S", "M", "L", "XL", "XXL"] },
    9: { id: 9, name: "Boys Striped Relaxed Fit Hooded Shirt", category: "Kids", subCategory: "T-Shirt", color: "Blue", price: 350, image: "kids/Boys Striped Relaxed Fit Hooded Shirt.avif", description: "The lightweight, breathable fabric keeps you cool and comfortable whether you're lounging on the beach or strolling around town. Designed with a relaxed collar and button-front closure, this shirt offers a laid-back vibe that pairs perfectly with jeans, shorts, or chinos.", sizes: ["S", "M", "L", "XL", "XXL"] },
    10: { id: 10, name: "Men Sneakers with PU Upper", category: "Men", subCategory: "Shoes", color: "White", price: 550, image: "images/shoes.avif", description: "Comfortable and stylish sneakers with a premium PU upper. Perfect for everyday wear and casual outings.", sizes: ["S", "M", "L", "XL", "XXL"] },
    11: { id: 11, name: "Women Stilettos with PU Upper", category: "Women", subCategory: "Shoes", color: "Blue", price: 1500, image: "women/Women Stilettos with PU Upper.avif", description: "Stunning designer heels in azure color. Perfect for special occasions and evening events. Comfortable yet stylish footwear.", sizes: ["S", "M", "L", "XL", "XXL"] },
    12: { id: 12, name: "Summer Floral Kurtas", category: "Women", subCategory: "Kurtas", color: "Floral", price: 650, image: "Suit (women).jpg", description: "Beautiful floral print summer dress. Lightweight and breathable for warm weather. Great for casual outings and beach days.", sizes: ["S", "M", "L", "XL", "XXL"] },
    13: { id: 13, name: "Men Printed Regular Fit Shirt with Full Sleeves", category: "Men", subCategory: "T-Shirt", color: "Printed", price: 500, image: "images/Men Printed Regular Fit Shirt with Full Sleeves.avif", description: "Classic men's printed regular fit shirt with full sleeves. Perfect for casual and semi-formal occasions.", sizes: ["S", "M", "L", "XL", "XXL"] },
    14: { id: 14, name: "Women's Oxford Shirt", category: "Women", subCategory: "T-Shirt", color: "White", price: 550, image: "Tshirt and shorts.jpg", description: "Crisp women's oxford shirt styled for a modern fit. Versatile for work or casual occasions.", sizes: ["S", "M", "L", "XL", "XXL"] },
    15: { id: 15, name: "PRINTED QUARTER-ZIP SWEATSHIRT", category: "Men", subCategory: "Hoodie", color: "Grey", price: 950, image: "images/PRINTED QUARTER-ZIP SWEATSHIRT.jpg", description: "Comfortable and stylish printed quarter-zip sweatshirt for men. Perfect for layering in colder weather.", sizes: ["S", "M", "L", "XL", "XXL"] },
    16: { id: 16, name: "Women Straight Fit Jeans with Drawstring Waist", category: "Women", subCategory: "Jeans", color: "Blue", price: 650, image: "women/women straight fit jeans.avif", description: "Comfortable straight fit jeans featuring a practical drawstring waist. Great for everyday casual wear.", sizes: ["S", "M", "L", "XL", "XXL"] },
    17: { id: 17, name: "Boys Numeric Print Boxy Fit Polo T-Shirt", category: "Kids", subCategory: "T-Shirt", color: "White", price: 550, image: "kids/Boys Numeric Print Boxy Fit Polo T-Shirt.avif", description: "Trendy boy's boxy fit polo t-shirt with dynamic numeric prints. Perfect for active kids.", sizes: ["S", "M", "L", "XL", "XXL"] },
    18: { id: 18, name: "Girls Floral Print Angrakha Kurta with Sharara & Dupatta", category: "Kids", subCategory: "Dress", color: "Floral", price: 450, image: "kids/Girls Floral Print Angrakha Kurta with Sharara & Dupatta.avif", description: "Beautiful traditional girl's set including floral print kurta, sharara and dupatta. Ideal for festive occasions.", sizes: ["S", "M", "L", "XL", "XXL"] },
    19: { id: 19, name: "Boys Graphic Print T-Shirt & Trackpant Set", category: "Kids", subCategory: "T-Shirt", color: "Black", price: 450, image: "kids/Boys Graphic Print T-Shirt & Trackpant Set.avif", description: "A comfortable matching set. Includes a graphic print t-shirt and trackpants for boys.", sizes: ["S", "M", "L", "XL", "XXL"] },
    20: { id: 20, name: "Urban Men's Sweater", category: "Men", subCategory: "Hoodie", color: "Black", price: 1380, image: "images/Urban Men's Sweater.jpg", description: "Cozy knit sweater that keeps you comfortable during the colder months. Features a classic design that pairs well with jeans or trousers.", sizes: ["S", "M", "L", "XL", "XXL"] },
    21: { id: 21, name: "Sporty Women's Cap", category: "Women", subCategory: "Accessories", color: "Black", price: 520, image: "women/sport women cap.webp", description: "Complete your casual look with this adjustable cap. Provides shade and adds a sporty touch to any casual ensemble.", sizes: ["Free Size"] },
    22: { id: 22, name: "Classic Men's Backpack", category: "Men", subCategory: "Accessories", color: "Green", price: 2090, image: "images/Classic Men's Backpack.avif", description: "Spacious and durable backpack with multiple compartments. Ideal for school, work, or carrying your essentials during travel.", sizes: ["Free Size"] },
    23: { id: 23, name: "Premium Women's Pants", category: "Women", subCategory: "Pants", color: "Grey", price: 2090, image: "women/Premium Women's Pants.avif", description: "Well-tailored pants offering a perfect fit. Ideal for both work and casual outings, providing comfort without compromising on style.", sizes: ["S", "M", "L", "XL", "XXL"] },
    24: { id: 24, name: "Premium Women's Sweater", category: "Women", subCategory: "Hoodie", color: "Beige", price: 1280, image: "women/Premium Women's Sweater.avif", description: "Cozy knit sweater that keeps you comfortable during the colder months. Features a classic design that pairs well with jeans or trousers.", sizes: ["S", "M", "L", "XL", "XXL"] },
    25: { id: 25, name: "Chic Kids's Backpack", category: "Kids", subCategory: "Accessories", color: "Blue", price: 510, image: "kids/Chic Kids's Backpack.avif", description: "Spacious and durable backpack with multiple compartments. Ideal for school, work, or carrying your essentials during travel.", sizes: ["Free Size"] },
    26: { id: 26, name: "Luxury Men's Sweater", category: "Men", subCategory: "Hoodie", color: "Black", price: 1570, image: "images/Luxury Men's Sweater.jpg", description: "Cozy knit sweater that keeps you comfortable during the colder months. Features a classic design that pairs well with jeans or trousers.", sizes: ["S", "M", "L", "XL", "XXL"] },
    27: { id: 27, name: "Urban Kids's Jewellery", category: "Kids", subCategory: "Accessories", color: "Gold", price: 900, image: "kids/Urban Kids's Jewellery.webp", description: "Add a touch of elegance to your attire with this exquisite piece of jewellery. Carefully crafted to sparkle and stand out.", sizes: ["Free Size"] },
    28: { id: 28, name: "Trendy Women's Sunglasses", category: "Women", subCategory: "Accessories", color: "Black", price: 1750, image: "women/Trendy Women's Sunglasses.webp", description: "Protect your eyes with style. These sunglasses offer superior UV protection and feature a trendy frame design.", sizes: ["Free Size"] },
    29: { id: 29, name: "Comfortable Men's Face Wash", category: "Men", subCategory: "Skincare", color: "Blue", price: 990, image: "images/Men's Face Wash.jpg", description: "Rejuvenate your skin with this refreshing face wash. Deeply cleanses pores, removes impurities, and leaves your skin feeling vibrant.", sizes: ["Free Size"] },
    30: { id: 30, name: "Premium Men's Sunglasses", category: "Men", subCategory: "Accessories", color: "Black", price: 410, image: "images/Premium Men's Sunglasses.webp", description: "Protect your eyes with style. These sunglasses offer superior UV protection and feature a trendy frame design.", sizes: ["Free Size"] },
    31: { id: 31, name: "Chic Women's Shoes", category: "Women", subCategory: "Shoes", color: "Black", price: 2470, image: "women/Chic Women's Shoes.jpg", description: "Step up your game with this comfortable and stylish footwear. Great for daily wear and providing excellent support for all your activities.", sizes: ["6", "7", "8", "9", "10", "11"] },
    32: { id: 32, name: "Comfortable Kids's Pants", category: "Kids", subCategory: "Pants", color: "Blue", price: 2120, image: "kids/Comfortable Kids's Pants.jpg", description: "Well-tailored pants offering a perfect fit. Ideal for both work and casual outings, providing comfort without compromising on style.", sizes: ["S", "M", "L", "XL", "XXL"] },
    33: { id: 33, name: "Sporty Women's Sweater", category: "Women", subCategory: "Hoodie", color: "Pink", price: 780, image: "women/Premium Women's Sweater.avif", description: "Cozy knit sweater that keeps you comfortable during the colder months. Features a classic design that pairs well with jeans or trousers.", sizes: ["S", "M", "L", "XL", "XXL"] },
    34: { id: 34, name: "Trendy Women's Jewellery", category: "Women", subCategory: "Accessories", color: "Silver", price: 2790, image: "women/Trendy Women's Jewellery.avif", description: "Add a touch of elegance to your attire with this exquisite piece of jewellery. Carefully crafted to sparkle and stand out.", sizes: ["Free Size"] },
    35: { id: 35, name: "Stylish Kids's T-Shirt", category: "Kids", subCategory: "T-Shirt", color: "White", price: 960, image: "kids/Kids's T-Shirt.jpg", description: "Soft and breathable cotton t-shirt with a relaxed fit. A versatile wardrobe essential for everyday casual wear.", sizes: ["S", "M", "L", "XL", "XXL"] },
    36: { id: 36, name: "Vintage Kids's Backpack", category: "Kids", subCategory: "Accessories", color: "Grey", price: 330, image: "kids/Vintage Kids's Backpack.jpg", description: "Spacious and durable backpack with multiple compartments. Ideal for school, work, or carrying your essentials during travel.", sizes: ["Free Size"] },
    37: { id: 37, name: "Vintage Kids's Jewellery", category: "Kids", subCategory: "Accessories", color: "Gold", price: 2640, image: "kids/Kids's Jewellery.jpg", description: "Add a touch of elegance to your attire with this exquisite piece of jewellery. Carefully crafted to sparkle and stand out.", sizes: ["Free Size"] },
    38: { id: 38, name: "Modern Kids's T-Shirt", category: "Kids", subCategory: "T-Shirt", color: "Black", price: 1120, image: "kids/Kids's T-Shirt.jpg", description: "Soft and breathable cotton t-shirt with a relaxed fit. A versatile wardrobe essential for everyday casual wear.", sizes: ["S", "M", "L", "XL", "XXL"] },
    39: { id: 39, name: "Classic Men's Jacket", category: "Men", subCategory: "Jacket", color: "Brown", price: 1120, image: "images/Classic Men's Jacket.avif", description: "Stay warm and look sharp. This jacket features premium materials and a comfortable inner lining, perfect for chilly weather.", sizes: ["S", "M", "L", "XL", "XXL"] },
    40: { id: 40, name: "Chic Kids's Sunglasses", category: "Kids", subCategory: "Accessories", color: "Red", price: 2720, image: "kids/Chic Kids's Sunglasses.jpg", description: "Protect your eyes with style. These sunglasses offer superior UV protection and feature a trendy frame design.", sizes: ["Free Size"] },
    41: { id: 41, name: "Luxury Men's Sunglasses", category: "Men", subCategory: "Accessories", color: "Gold", price: 1440, image: "images/Men's Sunglasses.jpg", description: "Protect your eyes with style. These sunglasses offer superior UV protection and feature a trendy frame design.", sizes: ["Free Size"] },
    42: { id: 42, name: "Comfortable Women's Sunglasses", category: "Women", subCategory: "Accessories", color: "Brown", price: 1760, image: "women/Comfortable Women's Sunglasses.jpg", description: "Protect your eyes with style. These sunglasses offer superior UV protection and feature a trendy frame design.", sizes: ["Free Size"] },
    43: { id: 43, name: "Elegant Kids's Shoes", category: "Kids", subCategory: "Shoes", color: "White", price: 2080, image: "kids/Kids's Shoes.webp", description: "Step up your game with this comfortable and stylish footwear. Great for daily wear and providing excellent support for all your activities.", sizes: ["6", "7", "8", "9", "10", "11"] },
    44: { id: 44, name: "Modern Kids's Sweater", category: "Kids", subCategory: "Hoodie", color: "Grey", price: 1450, image: "kids/Kids's Sweater.avif", description: "Cozy knit sweater that keeps you comfortable during the colder months. Features a classic design that pairs well with jeans or trousers.", sizes: ["S", "M", "L", "XL", "XXL"] },
    45: { id: 45, name: "Premium Kids's Cap", category: "Kids", subCategory: "Accessories", color: "Black", price: 1320, image: "kids/Kids's Cap.avif", description: "Complete your casual look with this adjustable cap. Provides shade and adds a sporty touch to any casual ensemble.", sizes: ["Free Size"] },
    46: { id: 46, name: "Casual Women's Shoes", category: "Women", subCategory: "Shoes", color: "White", price: 320, image: "women/Women's Shoes.webp", description: "Step up your game with this comfortable and stylish footwear. Great for daily wear and providing excellent support for all your activities.", sizes: ["6", "7", "8", "9", "10", "11"] },
    47: { id: 47, name: "Durable Women's Backpack", category: "Women", subCategory: "Accessories", color: "Black", price: 2550, image: "women/Women's Backpack.jpg", description: "Spacious and durable backpack with multiple compartments. Ideal for school, work, or carrying your essentials during travel.", sizes: ["Free Size"] },
    48: { id: 48, name: "Sporty Kids's Sweater", category: "Kids", subCategory: "Hoodie", color: "Red", price: 2580, image: "kids/Sporty Kids's Sweater.avif", description: "Cozy knit sweater that keeps you comfortable during the colder months. Features a classic design that pairs well with jeans or trousers.", sizes: ["S", "M", "L", "XL", "XXL"] },
    49: { id: 49, name: "Urban Women's Watch", category: "Women", subCategory: "Accessories", color: "Silver", price: 890, image: "women/Urban Women's Watch.webp", description: "A sleek and sophisticated timepiece that complements any outfit. Features precise timekeeping and a durable strap.", sizes: ["Free Size"] },
    50: { id: 50, name: "Chic Kids's Track Pants", category: "Kids", subCategory: "Pants", color: "Grey", price: 2580, image: "kids/Chic Kids's Track Pants.webp", description: "Breathable and stretchable track pants designed for active lifestyles. Perfect for workouts, jogging, or simply lounging at home.", sizes: ["S", "M", "L", "XL", "XXL"] },
    51: { id: 51, name: "Classic Women's Sunglasses", category: "Women", subCategory: "Accessories", color: "Black", price: 1890, image: "women/Classic Women's Sunglasses.jpg", description: "Protect your eyes with style. These sunglasses offer superior UV protection and feature a trendy frame design.", sizes: ["Free Size"] },
    52: { id: 52, name: "Luxury Kids's Jewellery", category: "Kids", subCategory: "Accessories", color: "Gold", price: 1030, image: "kids/Luxury Kids's Jewellery.avif", description: "Add a touch of elegance to your attire with this exquisite piece of jewellery. Carefully crafted to sparkle and stand out.", sizes: ["Free Size"] },
    53: { id: 53, name: "Stylish Men's Face Wash", category: "Men", subCategory: "Skincare", color: "White", price: 2600, image: "images/Stylish Men's Face Wash.jpg", description: "Rejuvenate your skin with this refreshing face wash. Deeply cleanses pores, removes impurities, and leaves your skin feeling vibrant.", sizes: ["Free Size"] },
    54: { id: 54, name: "Chic Kids's T-Shirt", category: "Kids", subCategory: "T-Shirt", color: "Pink", price: 810, image: "kids/Chic Kids's T-Shirt.avif", description: "Soft and breathable cotton t-shirt with a relaxed fit. A versatile wardrobe essential for everyday casual wear.", sizes: ["S", "M", "L", "XL", "XXL"] },
    // 55: { id: 55, name: "Classic Kids's Jewellery", category: "Kids", price: 2620, image: "https://via.placeholder.com/300x400?text=Classic+Kids's+Jewellery", description: "Add a touch of elegance to your attire with this exquisite piece of jewellery. Carefully crafted to sparkle and stand out.", sizes: ["Free Size"] },
    56: { id: 56, name: "Durable Women's Cap", category: "Women", subCategory: "Accessories", color: "Blue", price: 2100, image: "women/Durable Women's Cap.jpg", description: "Complete your casual look with this adjustable cap. Provides shade and adds a sporty touch to any casual ensemble.", sizes: ["Free Size"] },
    57: { id: 57, name: "Trendy Kids's T-Shirt", category: "Kids", subCategory: "T-Shirt", color: "White", price: 2380, image: "kids/Trendy Kids's T-Shirt.webp", description: "Soft and breathable cotton t-shirt with a relaxed fit. A versatile wardrobe essential for everyday casual wear.", sizes: ["S", "M", "L", "XL", "XXL"] },
    58: { id: 58, name: "Premium Men's T-Shirt", category: "Men", subCategory: "T-Shirt", color: "Black", price: 2520, image: "images/Premium Men's T-Shirt.jpg", description: "Soft and breathable cotton t-shirt with a relaxed fit. A versatile wardrobe essential for everyday casual wear.", sizes: ["S", "M", "L", "XL", "XXL"] },
    59: { id: 59, name: "Cargo Pant", category: "Men", subCategory: "Trousers", color: "black", price: 840, image: "images/pent men.jpg", description: "Boys Relaxed Straight Fit Cotton Cargo Pant", sizes: ["28","30", "32", "34", "36", "38"] },
    60: { id: 60, name: "Boys Loose Baggy", category: "Kids", subCategory: "Jeans", color: "Blue", price: 800, image: "kids/Boys Loose Baggy Fit.jpg", description: "Boys Loose Baggy Fit Washed Stretchable Denim Jeans", sizes: ["S", "M", "L", "XL", "XXL"] },
    61: { id: 61, name: "Saree", category: "Women", subCategory: "Saree", color: "Red", price: 1830, image: "women/Saree.webp", description: "Embellished Embroidered Pure Georgette Designer Saree", sizes: ["S", "M", "L", "XL", "XXL"] },
    62: { id: 62, name: "Casual Shirt", category: "Men", subCategory: "Casual Shirts", color: "Brown", price: 1720, image: "images/Men Casual Shirt.jpg", description: "Men Casual Linen Solid Slim Fit Shirt.", sizes: ["Free Size"] },
    63: { id: 63, name: "Linen Shirt", category: "Men", subCategory: "Casual Shirts", color: "Brown", price: 430, image: "images/Roadster Men Shirts.jpg", description: "Men Premium Linen Cotton Casual Shirt", sizes: ["M", "L", "XL", "XXL"] },
    64: { id: 64, name: "Midi Dress", category: "Women", subCategory: "Dresses", color: "Green", price: 700, image: "women/Womens Dress.jpg", description: "Green & Pink Ethnic Motifs Printed Tiered Pure Cotton A-Line Midi Dress", sizes: ["S", "M", "L", "XL", "XXL"] },
    65: { id: 65, name: "Cool Dress", category: "Women", subCategory: "Dresses", color: "Pink", price: 2240, image: "women/one piece.webp", description: "Women Floral Printed Fit & Flare Midi Dress.", sizes: ["6", "7", "8", "9", "10", "11"] },
    66: { id: 66, name: "Premium Perfume", category: "Women", subCategory: "Premium Fragrancess", color: "White", price: 740, image: "women/perfume.webp", description: "Good Perfume", sizes: ["Free Size"]},
    67: { id: 67, name: "Sweatband Cap", category: "Men", subCategory: "Accessories", color: "Black", price: 230, image: "images/men cap.jpg", description: "Men Solid Training UV Guard & Dry Fit Sweatband Cap", sizes: ["Free Size"] },
    68: { id: 68, name: "Durable Men's T-Shirt", category: "Men", subCategory: "T-Shirt", color: "Green", price: 920, image: "images/tshirt men.webp", description: "Soft and breathable cotton t-shirt with a relaxed fit. A versatile wardrobe essential for everyday casual wear.", sizes: ["S", "M", "L", "XL", "XXL"] },
    69: { id: 69, name: "Men Watch", category: "Men", subCategory: "Watch", color: "Brown", price: 620, image: "images/Men Leather Watch.jpg", description: "Buy Men Multi Function Analogue Leather Watch .", sizes: ["Free Size"] },
    70: { id: 70, name: "Men Wallet", category: "Men", subCategory: "Wallets", color: "Blue", price: 640, image: "images\men wallets.jpg", description: "Blue Wallet.", sizes: ["Free Size"] },
    // 71: { id: 71, name: "Stylish Women's Face Wash", category: "Women", subCategory: "Skincare", color: "White", price: 1560, image: "https://via.placeholder.com/300x400?text=Stylish+Women's+Face+Wash", description: "Rejuvenate your skin with this refreshing face wash. Deeply cleanses pores, removes impurities, and leaves your skin feeling vibrant.", sizes: ["Free Size"] },
    // 72: { id: 72, name: "Trendy Kids's Shoes", category: "Kids", subCategory: "Shoes", color: "Blue", price: 930, image: "https://via.placeholder.com/300x400?text=Trendy+Kids's+Shoes", description: "Step up your game with this comfortable and stylish footwear. Great for daily wear and providing excellent support for all your activities.", sizes: ["6", "7", "8", "9", "10", "11"] },
    // 73: { id: 73, name: "Vintage Women's Track Pants", category: "Women", subCategory: "Pants", color: "Pink", price: 390, image: "https://via.placeholder.com/300x400?text=Vintage+Women's+Track+Pants", description: "Breathable and stretchable track pants designed for active lifestyles. Perfect for workouts, jogging, or simply lounging at home.", sizes: ["S", "M", "L", "XL", "XXL"] },
    // 74: { id: 74, name: "Stylish Men's Shoes", category: "Men", subCategory: "Shoes", color: "Black", price: 680, image: "https://via.placeholder.com/300x400?text=Stylish+Men's+Shoes", description: "Step up your game with this comfortable and stylish footwear. Great for daily wear and providing excellent support for all your activities.", sizes: ["6", "7", "8", "9", "10", "11"] },
    // 75: { id: 75, name: "Stylish Women's Sunglasses", category: "Women", subCategory: "Accessories", color: "Pink", price: 980, image: "https://via.placeholder.com/300x400?text=Stylish+Women's+Sunglasses", description: "Protect your eyes with style. These sunglasses offer superior UV protection and feature a trendy frame design.", sizes: ["Free Size"] },
    // 76: { id: 76, name: "Durable Men's Backpack", category: "Men", subCategory: "Accessories", color: "Blue", price: 870, image: "https://via.placeholder.com/300x400?text=Durable+Men's+Backpack", description: "Spacious and durable backpack with multiple compartments. Ideal for school, work, or carrying your essentials during travel.", sizes: ["Free Size"] },
    // 77: { id: 77, name: "Premium Men's Cap", category: "Men", subCategory: "Accessories", color: "Grey", price: 1720, image: "https://via.placeholder.com/300x400?text=Premium+Men's+Cap", description: "Complete your casual look with this adjustable cap. Provides shade and adds a sporty touch to any casual ensemble.", sizes: ["Free Size"] },
    // 78: { id: 78, name: "Chic Women's Shoes", category: "Women", subCategory: "Shoes", color: "Red", price: 1250, image: "https://via.placeholder.com/300x400?text=Chic+Women's+Shoes", description: "Step up your game with this comfortable and stylish footwear. Great for daily wear and providing excellent support for all your activities.", sizes: ["6", "7", "8", "9", "10", "11"] },
    // 79: { id: 79, name: "Classic Men's T-Shirt", category: "Men", subCategory: "T-Shirt", color: "White", price: 1900, image: "https://via.placeholder.com/300x400?text=Classic+Men's+T-Shirt", description: "Soft and breathable cotton t-shirt with a relaxed fit. A versatile wardrobe essential for everyday casual wear.", sizes: ["S", "M", "L", "XL", "XXL"] },
    // 80: { id: 80, name: "Trendy Women's Watch", category: "Women", subCategory: "Accessories", color: "Gold", price: 2260, image: "https://via.placeholder.com/300x400?text=Trendy+Women's+Watch", description: "A sleek and sophisticated timepiece that complements any outfit. Features precise timekeeping and a durable strap.", sizes: ["Free Size"] },
    // 81: { id: 81, name: "Elegant Women's Face Wash", category: "Women", subCategory: "Skincare", color: "Pink", price: 2690, image: "https://via.placeholder.com/300x400?text=Elegant+Women's+Face+Wash", description: "Rejuvenate your skin with this refreshing face wash. Deeply cleanses pores, removes impurities, and leaves your skin feeling vibrant.", sizes: ["Free Size"] },
    // 82: { id: 82, name: "Comfortable Kids's Backpack", category: "Kids", subCategory: "Accessories", color: "Green", price: 2020, image: "https://via.placeholder.com/300x400?text=Comfortable+Kids's+Backpack", description: "Spacious and durable backpack with multiple compartments. Ideal for school, work, or carrying your essentials during travel.", sizes: ["Free Size"] },
    // 83: { id: 83, name: "Classic Women's Sunglasses", category: "Women", subCategory: "Accessories", color: "Brown", price: 2840, image: "https://via.placeholder.com/300x400?text=Classic+Women's+Sunglasses", description: "Protect your eyes with style. These sunglasses offer superior UV protection and feature a trendy frame design.", sizes: ["Free Size"] },
    // 84: { id: 84, name: "Urban Men's Sweater", category: "Men", subCategory: "Hoodie", color: "Grey", price: 1390, image: "https://via.placeholder.com/300x400?text=Urban+Men's+Sweater", description: "Cozy knit sweater that keeps you comfortable during the colder months. Features a classic design that pairs well with jeans or trousers.", sizes: ["S", "M", "L", "XL", "XXL"] },
    // 85: { id: 85, name: "Modern Kids's Shoes", category: "Kids", subCategory: "Shoes", color: "Black", price: 2970, image: "https://via.placeholder.com/300x400?text=Modern+Kids's+Shoes", description: "Step up your game with this comfortable and stylish footwear. Great for daily wear and providing excellent support for all your activities.", sizes: ["6", "7", "8", "9", "10", "11"] },
    // 86: { id: 86, name: "Urban Women's T-Shirt", category: "Women", subCategory: "T-Shirt", color: "Grey", price: 2090, image: "https://via.placeholder.com/300x400?text=Urban+Women's+T-Shirt", description: "Soft and breathable cotton t-shirt with a relaxed fit. A versatile wardrobe essential for everyday casual wear.", sizes: ["S", "M", "L", "XL", "XXL"] },
    // 87: { id: 87, name: "Vintage Kids's Sweater", category: "Kids", subCategory: "Hoodie", color: "Yellow", price: 1030, image: "https://via.placeholder.com/300x400?text=Vintage+Kids's+Sweater", description: "Cozy knit sweater that keeps you comfortable during the colder months. Features a classic design that pairs well with jeans or trousers.", sizes: ["S", "M", "L", "XL", "XXL"] },
    // 88: { id: 88, name: "Vintage Women's Jewellery", category: "Women", subCategory: "Accessories", color: "Silver", price: 2620, image: "https://via.placeholder.com/300x400?text=Vintage+Women's+Jewellery", description: "Add a touch of elegance to your attire with this exquisite piece of jewellery. Carefully crafted to sparkle and stand out.", sizes: ["Free Size"] },
    // 89: { id: 89, name: "Modern Men's Face Wash", category: "Men", subCategory: "Skincare", color: "Black", price: 1770, image: "https://via.placeholder.com/300x400?text=Modern+Men's+Face+Wash", description: "Rejuvenate your skin with this refreshing face wash. Deeply cleanses pores, removes impurities, and leaves your skin feeling vibrant.", sizes: ["Free Size"] },
    // 90: { id: 90, name: "Casual Women's Track Pants", category: "Women", subCategory: "Pants", color: "Blue", price: 1080, image: "https://via.placeholder.com/300x400?text=Casual+Women's+Track+Pants", description: "Breathable and stretchable track pants designed for active lifestyles. Perfect for workouts, jogging, or simply lounging at home.", sizes: ["S", "M", "L", "XL", "XXL"] },
    // 91: { id: 91, name: "Sporty Men's Jewellery", category: "Men", subCategory: "Accessories", color: "Black", price: 790, image: "https://via.placeholder.com/300x400?text=Sporty+Men's+Jewellery", description: "Add a touch of elegance to your attire with this exquisite piece of jewellery. Carefully crafted to sparkle and stand out.", sizes: ["Free Size"] },
    // 92: { id: 92, name: "Classic Women's Jacket", category: "Women", subCategory: "Jacket", color: "Black", price: 300, image: "https://via.placeholder.com/300x400?text=Classic+Women's+Jacket", description: "Stay warm and look sharp. This jacket features premium materials and a comfortable inner lining, perfect for chilly weather.", sizes: ["S", "M", "L", "XL", "XXL"] },
    // 93: { id: 93, name: "Stylish Women's Shoes", category: "Women", subCategory: "Shoes", color: "Black", price: 1940, image: "https://via.placeholder.com/300x400?text=Stylish+Women's+Shoes", description: "Step up your game with this comfortable and stylish footwear. Great for daily wear and providing excellent support for all your activities.", sizes: ["6", "7", "8", "9", "10", "11"] },
    // 94: { id: 94, name: "Durable Men's Pants", category: "Men", subCategory: "Pants", color: "Grey", price: 2460, image: "https://via.placeholder.com/300x400?text=Durable+Men's+Pants", description: "Well-tailored pants offering a perfect fit. Ideal for both work and casual outings, providing comfort without compromising on style.", sizes: ["S", "M", "L", "XL", "XXL"] },
    // 95: { id: 95, name: "Modern Men's Cap", category: "Men", subCategory: "Accessories", color: "Black", price: 2430, image: "https://via.placeholder.com/300x400?text=Modern+Men's+Cap", description: "Complete your casual look with this adjustable cap. Provides shade and adds a sporty touch to any casual ensemble.", sizes: ["Free Size"] },
    // 96: { id: 96, name: "Trendy Kids's Cap", category: "Kids", subCategory: "Accessories", color: "Blue", price: 2070, image: "https://via.placeholder.com/300x400?text=Trendy+Kids's+Cap", description: "Complete your casual look with this adjustable cap. Provides shade and adds a sporty touch to any casual ensemble.", sizes: ["Free Size"] },
    // 97: { id: 97, name: "Durable Women's Jewellery", category: "Women", subCategory: "Accessories", color: "Gold", price: 1310, image: "https://via.placeholder.com/300x400?text=Durable+Women's+Jewellery", description: "Add a touch of elegance to your attire with this exquisite piece of jewellery. Carefully crafted to sparkle and stand out.", sizes: ["Free Size"] },
    // 98: { id: 98, name: "Urban Women's Sunglasses", category: "Women", subCategory: "Accessories", color: "White", price: 380, image: "https://via.placeholder.com/300x400?text=Urban+Women's+Sunglasses", description: "Protect your eyes with style. These sunglasses offer superior UV protection and feature a trendy frame design.", sizes: ["Free Size"] },
    // 99: { id: 99, name: "Sporty Kids's Jacket", category: "Kids", subCategory: "Jacket", color: "Red", price: 2040, image: "https://via.placeholder.com/300x400?text=Sporty+Kids's+Jacket", description: "Stay warm and look sharp. This jacket features premium materials and a comfortable inner lining, perfect for chilly weather.", sizes: ["S", "M", "L", "XL", "XXL"] },
    // 100: { id: 100, name: "Urban Kids's Sunglasses", category: "Kids", subCategory: "Accessories", color: "Black", price: 1560, image: "https://via.placeholder.com/300x400?text=Urban+Kids's+Sunglasses", description: "Protect your eyes with style. These sunglasses offer superior UV protection and feature a trendy frame design.", sizes: ["Free Size"] },
    // 101: { id: 101, name: "Modern Women's Sunglasses", category: "Women", subCategory: "Accessories", color: "Black", price: 2990, image: "https://via.placeholder.com/300x400?text=Modern+Women's+Sunglasses", description: "Protect your eyes with style. These sunglasses offer superior UV protection and feature a trendy frame design.", sizes: ["Free Size"] },
    // 102: { id: 102, name: "Classic Kids's Cap", category: "Kids", subCategory: "Accessories", color: "Red", price: 730, image: "https://via.placeholder.com/300x400?text=Classic+Kids's+Cap", description: "Complete your casual look with this adjustable cap. Provides shade and adds a sporty touch to any casual ensemble.", sizes: ["Free Size"] },
    // 103: { id: 103, name: "Durable Men's Pants", category: "Men", subCategory: "Pants", color: "Brown", price: 1360, image: "https://via.placeholder.com/300x400?text=Durable+Men's+Pants", description: "Well-tailored pants offering a perfect fit. Ideal for both work and casual outings, providing comfort without compromising on style.", sizes: ["S", "M", "L", "XL", "XXL"] },
    // 104: { id: 104, name: "Luxury Kids's Backpack", category: "Kids", subCategory: "Accessories", color: "Pink", price: 2500, image: "https://via.placeholder.com/300x400?text=Luxury+Kids's+Backpack", description: "Spacious and durable backpack with multiple compartments. Ideal for school, work, or carrying your essentials during travel.", sizes: ["Free Size"] },
    // 105: { id: 105, name: "Classic Kids's Cap", category: "Kids", subCategory: "Accessories", color: "Blue", price: 1630, image: "https://via.placeholder.com/300x400?text=Classic+Kids's+Cap", description: "Complete your casual look with this adjustable cap. Provides shade and adds a sporty touch to any casual ensemble.", sizes: ["Free Size"] },
    // 106: { id: 106, name: "Trendy Men's Track Pants", category: "Men", subCategory: "Pants", color: "Black", price: 2330, image: "https://via.placeholder.com/300x400?text=Trendy+Men's+Track+Pants", description: "Breathable and stretchable track pants designed for active lifestyles. Perfect for workouts, jogging, or simply lounging at home.", sizes: ["S", "M", "L", "XL", "XXL"] },
    // 107: { id: 107, name: "Casual Kids's Watch", category: "Kids", subCategory: "Accessories", color: "Green", price: 470, image: "https://via.placeholder.com/300x400?text=Casual+Kids's+Watch", description: "A sleek and sophisticated timepiece that complements any outfit. Features precise timekeeping and a durable strap.", sizes: ["Free Size"] },
    // 108: { id: 108, name: "Elegant Women's Cap", category: "Women", subCategory: "Accessories", color: "Beige", price: 500, image: "https://via.placeholder.com/300x400?text=Elegant+Women's+Cap", description: "Complete your casual look with this adjustable cap. Provides shade and adds a sporty touch to any casual ensemble.", sizes: ["Free Size"] },
    // 109: { id: 109, name: "Casual Kids's Watch", category: "Kids", subCategory: "Accessories", color: "Pink", price: 2480, image: "https://via.placeholder.com/300x400?text=Casual+Kids's+Watch", description: "A sleek and sophisticated timepiece that complements any outfit. Features precise timekeeping and a durable strap.", sizes: ["Free Size"] },
    // 110: { id: 110, name: "Modern Men's Jacket", category: "Men", subCategory: "Jacket", color: "Black", price: 2450, image: "https://via.placeholder.com/300x400?text=Modern+Men's+Jacket", description: "Stay warm and look sharp. This jacket features premium materials and a comfortable inner lining, perfect for chilly weather.", sizes: ["S", "M", "L", "XL", "XXL"] },
    // 111: { id: 111, name: "Durable Kids's Jacket", category: "Kids", subCategory: "Jacket", color: "Blue", price: 1410, image: "https://via.placeholder.com/300x400?text=Durable+Kids's+Jacket", description: "Stay warm and look sharp. This jacket features premium materials and a comfortable inner lining, perfect for chilly weather.", sizes: ["S", "M", "L", "XL", "XXL"] },
    // 112: { id: 112, name: "Classic Kids's Sweater", category: "Kids", subCategory: "Hoodie", color: "White", price: 1570, image: "https://via.placeholder.com/300x400?text=Classic+Kids's+Sweater", description: "Cozy knit sweater that keeps you comfortable during the colder months. Features a classic design that pairs well with jeans or trousers.", sizes: ["S", "M", "L", "XL", "XXL"] },
    // 113: { id: 113, name: "Luxury Men's Track Pants", category: "Men", subCategory: "Pants", color: "Gold", price: 760, image: "https://via.placeholder.com/300x400?text=Luxury+Men's+Track+Pants", description: "Breathable and stretchable track pants designed for active lifestyles. Perfect for workouts, jogging, or simply lounging at home.", sizes: ["S", "M", "L", "XL", "XXL"] },
    // 114: { id: 114, name: "Trendy Kids's Jacket", category: "Kids", subCategory: "Jacket", color: "Green", price: 2540, image: "https://via.placeholder.com/300x400?text=Trendy+Kids's+Jacket", description: "Stay warm and look sharp. This jacket features premium materials and a comfortable inner lining, perfect for chilly weather.", sizes: ["S", "M", "L", "XL", "XXL"] },
    // 115: { id: 115, name: "Trendy Kids's Watch", category: "Kids", subCategory: "Accessories", color: "Silver", price: 2760, image: "https://via.placeholder.com/300x400?text=Trendy+Kids's+Watch", description: "A sleek and sophisticated timepiece that complements any outfit. Features precise timekeeping and a durable strap.", sizes: ["Free Size"] },
    // 116: { id: 116, name: "Classic Women's Backpack", category: "Women", subCategory: "Accessories", color: "Blue", price: 2610, image: "https://via.placeholder.com/300x400?text=Classic+Women's+Backpack", description: "Spacious and durable backpack with multiple compartments. Ideal for school, work, or carrying your essentials during travel.", sizes: ["Free Size"] },
    // 117: { id: 117, name: "Trendy Women's Sunglasses", category: "Women", subCategory: "Accessories", color: "Red", price: 2740, image: "https://via.placeholder.com/300x400?text=Trendy+Women's+Sunglasses", description: "Protect your eyes with style. These sunglasses offer superior UV protection and feature a trendy frame design.", sizes: ["Free Size"] },
    // 118: { id: 118, name: "Chic Men's Sweater", category: "Men", subCategory: "Hoodie", color: "White", price: 670, image: "https://via.placeholder.com/300x400?text=Chic+Men's+Sweater", description: "Cozy knit sweater that keeps you comfortable during the colder months. Features a classic design that pairs well with jeans or trousers.", sizes: ["S", "M", "L", "XL", "XXL"] },
    // 119: { id: 119, name: "Premium Kids's Pants", category: "Kids", subCategory: "Pants", color: "Black", price: 1320, image: "https://via.placeholder.com/300x400?text=Premium+Kids's+Pants", description: "Well-tailored pants offering a perfect fit. Ideal for both work and casual outings, providing comfort without compromising on style.", sizes: ["S", "M", "L", "XL", "XXL"] }
};

// ========== CART MANAGEMENT ==========
let cart = JSON.parse(localStorage.getItem('FASHIOFY_cart')) || [];
// normalize old format (no quantity)
cart = cart.map(item => {
    if (item.qty) return item;
    return { ...item, qty: 1 };
});
let wishlist = JSON.parse(localStorage.getItem('FASHIOFY_wishlist')) || [];

// ========== FILTERING STATE ==========
let activeFilters = {
    subCategory: [],
    color: [],
    size: [],
    price: null // {min: 0, max: 1000}
};

// Update the little red number on load
document.addEventListener('DOMContentLoaded', function () {
    console.log('script.js DOMContentLoaded');
    updateBadge();
    updateWishlistBadge();
    setupSearchBar();
    displayLoggedInUser();

    // Routing based on page elements
    if (document.getElementById('home-product-grid')) {
        renderCategoryFilters();
        populateHomeProducts();
    }
    
    const catGrid = document.getElementById('category-product-grid');
    if (catGrid) {
        populateCategoryProducts(catGrid.getAttribute('data-category'));
    }

    if (document.getElementById('cart-grid')) {
        renderCart();
    }

    if (document.getElementById('product-name')) {
        loadProductDetails();
    }

    if (document.getElementById('summary-items')) {
        renderCheckoutSummary();
    }

    if (document.getElementById('results-list')) {
        const query = new URLSearchParams(window.location.search).get('q') || '';
        renderSearchResults(query);
    }

    if (document.getElementById('wishlist-grid')) {
        renderWishlist();
    }

    // If on checkout page, clear the cart to prevent old data (only after purchase or per original logic)
    // The original code had a bug where it cleared on load; I'll remove that or fix it if needed.
    // Original logic: if (document.getElementById('checkout-form')) { cart = []; ... }
    // better to clear after successful order placement.
});


function updateBadge() {
    const badge = document.getElementById('cart-count');
    if (badge) {
        const totalQty = cart.reduce((sum, it) => sum + (it.qty || 0), 0);
        badge.innerText = totalQty;
    }
}

function updateWishlistBadge() {
    const badge = document.getElementById('header-wishlist-count');
    if (badge) {
        badge.innerText = wishlist.length;
        badge.style.display = wishlist.length > 0 ? 'inline' : 'none';
    }
}

function addToCart(btn, name, price) {
    // Find the product to get available sizes
    let productId = null;
    let defaultSize = 'M'; // Default size
    for (let id in products) {
        if (products[id].name === name && products[id].price === price) {
            productId = id;
            if (products[id].sizes && products[id].sizes.length > 0) {
                defaultSize = products[id].sizes[0]; // Use first available size as default
            }
            break;
        }
    }

    // 2. Add to cart logic
    let existing = cart.find(it => it.name === name && it.price === price && it.size === defaultSize);
    if (existing) {
        existing.qty = (existing.qty || 1) + 1;
    } else {
        cart.push({ name, price, size: defaultSize, qty: 1 });
    }
    localStorage.setItem('FASHIOFY_cart', JSON.stringify(cart));

    // 3. Update Badge
    updateBadge();

    // 4. Show "Toast" Notification (Redesigned)
    const toast = document.getElementById('toast');
    toast.innerHTML = `
        <div style="display:flex; align-items:center; gap:15px; text-align:left;">
            <div style="font-size:1.5rem;">🛍️</div>
            <div>
                <div style="font-weight:800; text-transform:uppercase; font-size:0.75rem; letter-spacing:1px; margin-bottom:2px; color:var(--accent);">Added to Bag</div>
                <div style="font-size:0.85rem; font-weight:600;">${name}</div>
                <div style="font-size:0.75rem; opacity:0.8;">Size: ${defaultSize}</div>
            </div>
        </div>
    `;
    toast.className = "show";
    setTimeout(function () { toast.className = ""; }, 4000);


    // 4. Change Button Text Temporarily
    const originalText = btn.innerText;
    btn.innerText = "✓ ADDED";
    btn.style.backgroundColor = "#c5a059"; // Gold

    setTimeout(() => {
        btn.innerText = originalText;
        btn.style.backgroundColor = "#111"; // Back to Black
    }, 1500);
}

function toggleCart() {
    // open cart page instead of alert
    window.location.href = 'cart.php';
}

// ========== PRODUCT DETAILS PAGE ==========
function setupProductLinks() {
    const productCards = document.querySelectorAll('.product-card');

    productCards.forEach(card => {
        const nameEl = card.querySelector('.product-info h3');
        const priceEl = card.querySelector('.product-info .price');

        if (!nameEl || !priceEl) return;

        const name = nameEl.innerText;
        const price = parseFloat(priceEl.innerText.replace('₹', ''));

        // Find product ID
        let productId = null;
        for (let id in products) {
            if (products[id].name === name && products[id].price === price) {
                productId = id;
                break;
            }
        }

        if (!productId) return;

        card.style.cursor = 'pointer';

        const gotoDetails = () => {
            const src = encodeURIComponent(window.location.pathname.split('/').pop() || 'index.php');
            window.open(`product-details.php?id=${productId}&source=${src}`, '_blank');
        };

        card.addEventListener('click', function (e) {
            if (e.target.closest('button') || e.target.closest('select') || e.target.matches('input')) {
                return;
            }
            gotoDetails();
        });

        const img = card.querySelector('.img-box img');
        if (img) {
            img.style.cursor = 'pointer';
            img.addEventListener('click', function (e) {
                e.preventDefault();
                gotoDetails();
            });
        }

        if (nameEl) {
            nameEl.style.cursor = 'pointer';
            nameEl.addEventListener('click', function (e) {
                e.preventDefault();
                gotoDetails();
            });
        }
    });
}

// ========== HOME PAGE HELPERS ==========

function getCategories() {
    const cats = new Set();
    for (let id in products) {
        if (products[id].category) {
            cats.add(products[id].category);
        }
    }
    return Array.from(cats).sort();
}

function renderCategoryFilters() {
    const filtersContainer = document.getElementById('category-filters');
    if (!filtersContainer) return;

    const categories = ['All', ...getCategories()];
    filtersContainer.innerHTML = '';

    categories.forEach(cat => {
        const button = document.createElement('button');
        button.textContent = cat;
        button.className = 'category-btn';
        if (cat === 'All') button.classList.add('active');
        button.addEventListener('click', function () {
            document.querySelectorAll('.category-btn').forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            populateHomeProducts(cat);
        });
        filtersContainer.appendChild(button);
    });
}

function populateHomeProducts(category = 'All') {
    // only run on index.php
    if (!document.getElementById('home-product-grid')) return;
    const grid = document.getElementById('home-product-grid');
    grid.innerHTML = '';

    for (let id in products) {
        const p = products[id];
        if (category !== 'All' && p.category !== category) continue;

        const card = document.createElement('div');
        card.className = 'product-card';
        card.innerHTML = `
            <div class="img-box" style="position: relative;">
                <button class="btn-wishlist" onclick="addToWishlist(${id}, event)" style="position: absolute; top: 15px; right: 15px; background: rgba(255, 255, 255, 0.9); border: none; border-radius: 50%; color: #e74c3c; width: 35px; height: 35px; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.15); z-index: 10; transition: transform 0.2s ease;">❤️</button>
                <img src="${p.image}" alt="${p.name}">
            </div>
            <div class="product-info">
                <h3>${p.name}</h3>
                <p class="price">₹${p.price}.00</p>
                <p style="font-size:0.9rem; color:#666; margin:0.5rem 0">${p.category}</p>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <button class="btn" onclick="addToCart(this, '${p.name}', ${p.price})">Add to Bag</button>
                </div>
            </div>
        `;
        grid.appendChild(card);
    }
    setupProductLinks();
}

function populateCategoryProducts(category) {
    const grid = document.getElementById('category-product-grid');
    if (!grid) return;

    // 1. Initial filter container
    const filterContainer = document.getElementById('filter-sidebar');
    
    // 2. Get products for this category
    const categoryProducts = [];
    for (let id in products) {
        if (products[id].category === category) {
            categoryProducts.push({ id, ...products[id] });
        }
    }

    // 3. Render filters initially if not already there
    if (filterContainer && filterContainer.innerHTML === '') {
        renderFilters('filter-sidebar', categoryProducts, () => {
            const filtered = applyFilters(categoryProducts);
            updateProductGrid(filtered, 'category-product-grid');
        });
    }

    // 4. Initial render
    updateProductGrid(categoryProducts, 'category-product-grid');
}

// ========== DYNAMIC FILTERING LOGIC ==========

function renderFilters(containerId, productsSet, onFilterChange) {
    const container = document.getElementById(containerId);
    if (!container) return;

    // Use a robust extraction for dynamic filters
    let subCategories = [];
    let colors = [];
    if (Array.isArray(productsSet) && productsSet.length > 0) {
        subCategories = [...new Set(productsSet.map(p => p.subCategory).filter(Boolean))].sort();
        colors = [...new Set(productsSet.map(p => p.color).filter(Boolean))].sort();
    }

    const sizes = ['S', 'M', 'L', 'XL', 'XXL', 'Free Size'];
    const priceLevels = [
        { label: "Under ₹500", min: 0, max: 500 },
        { label: "₹500 - ₹1000", min: 500, max: 1000 },
        { label: "₹1000 - ₹2000", min: 1000, max: 2000 },
        { label: "Over ₹2000", min: 2000, max: 100000 }
    ];

    let html = '';

    // Static Filters First: Size and Price (Guarantees sidebar is never empty)
    html += `
    <div class="filter-group">
        <h4 class="filter-title">Price Range</h4>
        <div class="filter-options">
            ${priceLevels.map((p, index) => `
                <label class="filter-label">
                    <input type="radio" name="price-filter" data-type="price" value="${index}">
                    <span>${p.label}</span>
                </label>
            `).join('')}
            <label class="filter-label">
                <input type="radio" name="price-filter" data-type="price" value="all" checked>
                <span>All Prices</span>
            </label>
        </div>
    </div>
    
    <div class="filter-group">
        <h4 class="filter-title">Size</h4>
        <div class="filter-options size-options">
            ${sizes.map(size => `
                <label class="filter-label size-label">
                    <input type="checkbox" data-type="size" value="${size}">
                    <span class="size-box">${size}</span>
                </label>
            `).join('')}
        </div>
    </div>`;

    // Dynamic Category Filters
    if (subCategories.length > 0) {
        html += `
        <div class="filter-group">
            <h4 class="filter-title">Category</h4>
            <div class="filter-options">
                ${subCategories.map(cat => `
                    <label class="filter-label">
                        <input type="checkbox" data-type="subCategory" value="${cat}">
                        <span>${cat}</span>
                    </label>
                `).join('')}
            </div>
        </div>`;
    }

    // Dynamic Color Filters
    if (colors.length > 0) {
        html += `
        <div class="filter-group">
            <h4 class="filter-title">Color</h4>
            <div class="filter-options color-options">
                ${colors.map(color => {
                    const bg = (color.toLowerCase() === 'floral' || color.toLowerCase() === 'printed') ? '#eee' : color;
                    return `
                    <label class="filter-label color-label" title="${color}">
                        <input type="checkbox" data-type="color" value="${color}">
                        <span class="color-swatch" style="background-color: ${bg}"></span>
                        <span>${color}</span>
                    </label>`;
                }).join('')}
            </div>
        </div>`;
    }

    html += `<button class="btn btn-small" style="width:100%; margin-top:20px; background:#333; color:white; border:none; padding:10px; cursor:pointer;" onclick="resetFilters()">Reset All</button>`;

    container.innerHTML = html;

    // Attach Listeners with explicit check
    container.querySelectorAll('input').forEach(input => {
        input.addEventListener('change', () => {
            const type = input.dataset.type;
            const val = input.value;

            if (type === 'price') {
                if (val === 'all') {
                    activeFilters.price = null;
                } else {
                    activeFilters.price = priceLevels[parseInt(val)];
                }
            } else {
                if (input.checked) {
                    if (!activeFilters[type].includes(val)) activeFilters[type].push(val);
                } else {
                    activeFilters[type] = activeFilters[type].filter(v => v !== val);
                }
            }
            if (typeof onFilterChange === 'function') onFilterChange();
        });
    });
}

function applyFilters(productsSet) {
    return productsSet.filter(p => {
        // Sub-category check
        if (activeFilters.subCategory.length > 0 && !activeFilters.subCategory.includes(p.subCategory)) return false;

        // Color check
        if (activeFilters.color.length > 0 && !activeFilters.color.includes(p.color)) return false;

        // Size check (product must have at least one of the selected sizes)
        if (activeFilters.size.length > 0) {
            const productSizes = p.sizes || [];
            if (!activeFilters.size.some(s => productSizes.includes(s))) return false;
        }

        // Price check
        if (activeFilters.price) {
            if (p.price < activeFilters.price.min || p.price > activeFilters.price.max) return false;
        }

        return true;
    });
}

function updateProductGrid(filteredProducts, containerId) {
    const grid = document.getElementById(containerId);
    if (!grid) return;

    if (filteredProducts.length === 0) {
        grid.innerHTML = `
            <div style="grid-column: 1/-1; text-align: center; padding: 3rem 0;">
                <h3 style="color: #999;">No products match your criteria.</h3>
                <p>Try adjusting your filters or clearing them all.</p>
            </div>
        `;
        return;
    }

    grid.innerHTML = '';
    filteredProducts.forEach(p => {
        const id = p.id;
        const card = document.createElement('div');
        card.className = 'product-card';
        card.innerHTML = `
            <div style="position: relative;">
                <button class="btn-wishlist" onclick="addToWishlist(${id}, event)" style="position: absolute; top: 15px; right: 15px; background: rgba(255, 255, 255, 0.9); border: none; border-radius: 50%; color: #e74c3c; width: 35px; height: 35px; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.15); z-index: 10; transition: transform 0.2s ease;">❤️</button>
                <a href="product-details.php?id=${id}" class="img-box" style="display: block;">
                    <img src="${p.image}" alt="${p.name}">
                </a>
            </div>
            <div class="product-info">
                <a href="product-details.php?id=${id}" style="text-decoration: none; color: inherit;">
                    <h3>${p.name}</h3>
                </a>
                <p class="price">₹${p.price}.00</p>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <button class="btn" onclick="addToCart(this, '${p.name}', ${p.price})">Add to Bag</button>
                </div>
            </div>
        `;
        grid.appendChild(card);
    });
    setupProductLinks();
}

function resetFilters() {
    activeFilters = { subCategory: [], color: [], size: [], price: null };
    const sidebar = document.querySelector('.filter-sidebar');
    if (sidebar) {
        sidebar.querySelectorAll('input[type="checkbox"]').forEach(i => i.checked = false);
        sidebar.querySelectorAll('input[type="radio"]').forEach(i => {
            if (i.value === 'all') i.checked = true;
            else i.checked = false;
        });
    }
    
    // Trigger re-render based on current page
    const catGrid = document.getElementById('category-product-grid');
    if (catGrid) {
        const category = catGrid.getAttribute('data-category');
        const categoryProducts = [];
        for (let id in products) {
            if (products[id].category === category) {
                categoryProducts.push({ id, ...products[id] });
            }
        }
        updateProductGrid(categoryProducts, 'category-product-grid');
    }

    const resultsList = document.getElementById('results-list');
    if (resultsList) {
        const query = new URLSearchParams(window.location.search).get('q') || '';
        renderSearchResults(query);
    }
}

function renderSearchResults(query = '') {
    const list = document.getElementById('results-list');
    const countDiv = document.getElementById('results-count');
    const searchInput = document.getElementById('results-search');
    const sidebar = document.getElementById('filter-sidebar');
    
    if (!list) return;

    if (searchInput) searchInput.value = query;

    // 1. Reset Global State for Fresh Search
    activeFilters = { subCategory: [], color: [], size: [], price: null };

    // 2. Clear UI
    list.innerHTML = '';
    if (sidebar) sidebar.innerHTML = '';
    
    // 3. Get matches
    const matching = getMatchingProducts(query);

    if (countDiv) {
        countDiv.innerText = `${matching.length} products found for "${query}"`;
    }

    if (matching.length === 0) {
        list.innerHTML = `
            <div class="no-results" style="grid-column: 1/-1; text-align:center; padding: 100px 20px;">
                <i class="fas fa-search" style="font-size: 4rem; color: #eee; margin-bottom: 20px; display:block;"></i>
                <h3 style="font-size: 1.5rem; margin-bottom: 10px;">No results found for "${query}"</h3>
                <p style="color: #888;">Try checking your spelling or use more general terms.</p>
            </div>
        `;
        return;
    }

    // 4. Populate Sidebar Filters and Grid
    if (sidebar) {
        renderFilters('filter-sidebar', matching, () => {
            const filtered = applyFilters(matching);
            updateProductGrid(filtered, 'results-list');
            if (countDiv) countDiv.innerText = `${filtered.length} products found for "${query}"`;
        });
    }

    updateProductGrid(matching, 'results-list');
}

function onSearchSubmit(event) {
    event.preventDefault();
    const queryEl = document.getElementById('results-search');
    if (queryEl) {
        const query = queryEl.value.trim();
        if (query) {
            // Update URL without reload if possible, or just re-render
            const newUrl = new URL(window.location);
            newUrl.searchParams.set('q', query);
            window.history.pushState({}, '', newUrl);
            renderSearchResults(query);
        }
    }
}

// ========== WISHLIST MANAGEMENT ==========
function addToWishlist(productId, event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    productId = productId.toString();
    const p = products[productId];
    if (!p) return;

    if (!wishlist.includes(productId)) {
        wishlist.push(productId);
        localStorage.setItem('FASHIOFY_wishlist', JSON.stringify(wishlist));
        updateWishlistBadge();
        
        const toast = document.getElementById('toast');
        if (toast) {
            toast.innerHTML = `
                <div style="display:flex; align-items:center; gap:15px; text-align:left;">
                    <div style="font-size:1.5rem;">❤️</div>
                    <div>
                        <div style="font-weight:800; text-transform:uppercase; font-size:0.75rem; letter-spacing:1px; margin-bottom:2px; color:var(--accent);">Added to Wishlist</div>
                        <div style="font-size:0.85rem; font-weight:600;">${p.name}</div>
                    </div>
                </div>
            `;
            toast.className = "show";
            setTimeout(function () { toast.className = ""; }, 4000);
        } else {
            alert(p.name + ' added to wishlist!');
        }
    } else {
        const toast = document.getElementById('toast');
        if (toast) {
            toast.innerHTML = `
                <div style="display:flex; align-items:center; gap:15px; text-align:left;">
                    <div style="font-size:1.5rem;">⚠️</div>
                    <div>
                        <div style="font-weight:800; text-transform:uppercase; font-size:0.75rem; letter-spacing:1px; margin-bottom:2px; color:var(--accent);">Notice</div>
                        <div style="font-size:0.85rem; font-weight:600;">This product is already in your wishlist.</div>
                    </div>
                </div>
            `;
            toast.className = "show";
            setTimeout(function () { toast.className = ""; }, 4000);
        } else {
            alert('This product is already in your wishlist!');
        }
    }
}

function removeFromWishlist(productId) {
    productId = productId.toString();
    wishlist = wishlist.filter(id => id !== productId);
    localStorage.setItem('FASHIOFY_wishlist', JSON.stringify(wishlist));
    location.reload();
}

function addToWishlistFromDetails() {
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');
    if (id) {
        addToWishlist(id);
    } else {
        alert('Product ID not found!');
    }
}

// ========== SEARCH FUNCTIONALITY ==========
function setupSearchBar() {
    const searchInput = document.getElementById('search-input');
    if (!searchInput) return;

    // pre-fill with current query if there is one (useful on results page)
    const params = new URLSearchParams(window.location.search);
    const current = params.get('q');
    if (current) {
        searchInput.value = decodeURIComponent(current);
    }

    // only react to Enter; do not filter the home grid live
    searchInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            const q = encodeURIComponent(this.value.trim());
            if (q.length === 0) return;
            window.location.href = `search-results.php?q=${q}`;
        }
    });
}

function filterProducts(query) {
    const productCards = document.querySelectorAll('.product-card');
    const searchTerm = query.toLowerCase();

    productCards.forEach(card => {
        const productName = card.querySelector('.product-info h3').innerText.toLowerCase();
        if (productName.includes(searchTerm)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}

// Helper used by search-results page to get matches programmatically
function getMatchingProducts(query) {
    if (!query) return [];
    
    // Normalize query
    const qRaw = query.toLowerCase().trim().replace(/'s/g, '').replace(/[^\w\s]/g, ' ');
    const words = qRaw.split(/\s+/).filter(w => w.length > 0);
    
    if (words.length === 0) return [];

    const categoryKeywords = {
        'men': 'men', 'mens': 'men',
        'women': 'women', 'womens': 'women',
        'kids': 'kids', 'kid': 'kids'
    };

    const out = [];
    for (let id in products) {
        const p = products[id];
        const pName = p.name.toLowerCase().replace(/'s/g, '');
        const pDesc = (p.description || '').toLowerCase();
        const pCat = (p.category || '').toLowerCase();
        const pSub = (p.subCategory || '').toLowerCase();
        const pColor = (p.color || '').toLowerCase();

        let matchesAll = words.every(word => {
            // Priority: Exact Category Match
            if (categoryKeywords[word]) {
                return pCat === categoryKeywords[word];
            }
            
            // Standard Fuzzy Match
            return pName.includes(word) || pDesc.includes(word) || pCat.includes(word) || pSub.includes(word) || pColor.includes(word);
        });

        if (matchesAll) {
            out.push({ id, ...p });
        }
    }
    return out;
}

// ========== LOGIN VALIDATION ==========
function validateLogin() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const phone = document.getElementById('phone').value;
    const emailError = document.getElementById('email-error');
    const passwordError = document.getElementById('password-error');
    const phoneError = document.getElementById('phone-error');

    // Reset errors
    if (emailError) emailError.innerText = '';
    if (passwordError) passwordError.innerText = '';
    if (phoneError) phoneError.innerText = '';

    let isValid = true;

    // Email/Username validation (user can use email or plain username)
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const usernameRegex = /^[a-zA-Z0-9._-]{3,30}$/;

    if (!email) {
        if (emailError) emailError.innerText = 'Email or username is required';
        isValid = false;
    } else if (!emailRegex.test(email) && !usernameRegex.test(email)) {
        if (emailError) emailError.innerText = 'Enter a valid email or username (3-30 chars)';
        isValid = false;
    }

    // Password validation
    if (!password) {
        if (passwordError) passwordError.innerText = 'Password is required';
        isValid = false;
    } else if (password.length < 6) {
        if (passwordError) passwordError.innerText = 'Password must be at least 6 characters';
        isValid = false;
    }

    // Phone validation (optional, but if provided, validate)
    if (phone && !/^\d{10}$/.test(phone.replace(/\s/g, ''))) {
        if (phoneError) phoneError.innerText = 'Enter a valid 10-digit phone number';
        isValid = false;
    }

    if (isValid) {
        // Send login data to server
        const formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);
        formData.append('phone', phone);

        fetch('login_handler.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Login successful! Welcome, ' + data.user.email);
                    // Store user data in localStorage for client-side use
                    localStorage.setItem('FASHIOFY_currentUser', data.user.email);
                    localStorage.setItem('FASHIOFY_userId', data.user.id);
                    localStorage.setItem('FASHIOFY_userDetails', JSON.stringify({
                        id: data.user.id,
                        email: data.user.email,
                        phone: data.user.phone,
                        createdAt: data.user.created_at,
                        lastLogin: data.user.last_login,
                        loginCount: data.user.login_count
                    }));
                    // Redirect to intended page or home
                    const urlParams = new URLSearchParams(window.location.search);
                    const redirect = urlParams.get('redirect') || 'index.php';
                    window.location.href = redirect;
                } else {
                    alert('Login failed: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Login error:', error);
                alert('Login failed. Please try again.');
            });
    }

    return false;
}

// ========== SOCIAL LOGIN SIMULATION ==========
function simulateSocialLogin(provider) {
    const btnId = provider.toLowerCase() + '-login-btn';
    const btn = document.getElementById(btnId);
    if (!btn) return;

    // Save original state
    const originalText = btn.innerHTML;
    
    // Set loading state
    btn.innerHTML = `<span style="font-size:14px;">Connecting to ${provider}...</span>`;
    btn.style.opacity = '0.7';
    btn.disabled = true;

    // Simulate network delay for OAuth redirect
    setTimeout(() => {
        // Generate mock user data
        const mockEmail = `user.123@${provider.toLowerCase()}.com`;
        const mockPassword = 'social_login_dummy_password_123!';

        // Send login data to server
        const formData = new FormData();
        formData.append('email', mockEmail);
        formData.append('password', mockPassword);
        formData.append('phone', '');

        fetch('login_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Store user data in localStorage for client-side use
                localStorage.setItem('FASHIOFY_currentUser', data.user.email);
                localStorage.setItem('FASHIOFY_userId', data.user.id);
                localStorage.setItem('FASHIOFY_userDetails', JSON.stringify({
                    id: data.user.id,
                    email: data.user.email,
                    phone: data.user.phone,
                    createdAt: data.user.created_at,
                    lastLogin: data.user.last_login,
                    loginCount: data.user.login_count
                }));
                
                showToast(`Successfully connected with ${provider}!`);
                
                // Redirect to intended page or home after brief delay to show toast
                setTimeout(() => {
                    const urlParams = new URLSearchParams(window.location.search);
                    const redirect = urlParams.get('redirect') || 'index.php';
                    window.location.href = redirect;
                }, 1000);
            } else {
                alert(`${provider} Login failed: ` + data.message);
                resetBtn();
            }
        })
        .catch(error => {
            console.error(`${provider} Login error:`, error);
            alert(`Could not connect to ${provider}. Please try again.`);
            resetBtn();
        });
    }, 1500); // 1.5 second simulated redirect/OAuth delay

    function resetBtn() {
        btn.innerHTML = originalText;
        btn.style.opacity = '1';
        btn.disabled = false;
    }
}

// ========== UI UTILITIES ==========
function showToast(message) {
    let toast = document.getElementById('toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'toast';
        document.body.appendChild(toast);
    }
    toast.innerText = message;
    toast.className = 'show';
    setTimeout(() => {
        toast.className = toast.className.replace('show', '');
    }, 3000);
}


function displayLoggedInUser() {
    const userBox = document.getElementById('user-profile');
    if (!userBox) return;

    const userEmail = localStorage.getItem('FASHIOFY_currentUser');
    const userDetails = JSON.parse(localStorage.getItem('FASHIOFY_userDetails') || 'null');

    if (!userEmail || !userDetails) {
        userBox.style.display = 'none';
        return;
    }

    userBox.style.display = 'block';
    userBox.innerHTML = `
        <div style="background:#fff; padding:20px; border:1px solid #eee; border-radius:8px; margin-bottom:30px;">
            <h3 style="margin:0 0 10px;">Logged in as:</h3>
            <p><strong>Email:</strong> ${userDetails.email}</p>
            ${userDetails.phone ? `<p><strong>Phone:</strong> ${userDetails.phone}</p>` : ''}
            <p><strong>Account created:</strong> ${new Date(userDetails.createdAt).toLocaleString()}</p>
            ${userDetails.lastLogin ? `<p><strong>Last login:</strong> ${new Date(userDetails.lastLogin).toLocaleString()}</p>` : ''}
            ${userDetails.loginCount ? `<p><strong>Login count:</strong> ${userDetails.loginCount}</p>` : ''}
            <button onclick="logoutUser()" style="padding:8px 14px; background:#e74c3c; color:white; border:none; border-radius:4px; cursor:pointer;">Logout</button>
        </div>
    `;
}

function setupPaymentDetailsSection() {
    console.log('setupPaymentDetailsSection() called');
    const paymentField = document.getElementById('payment');
    if (!paymentField) {
        console.error('payment field not found');
        return;
    }
    console.log('payment field found:', paymentField);

    const updatePaymentDetails = () => {
        const method = paymentField.value;
        console.log('Payment method changed to:', method);

        const cardGroup = document.getElementById('card-details-group');
        const upiGroup = document.getElementById('upi-details-group');
        const netbankingGroup = document.getElementById('netbanking-details-group');
        const codGroup = document.getElementById('cod-details-group');

        console.log('Form groups found:', { cardGroup, upiGroup, netbankingGroup, codGroup });

        // Hide all groups
        if (cardGroup) cardGroup.style.display = 'none';
        if (upiGroup) upiGroup.style.display = 'none';
        if (netbankingGroup) netbankingGroup.style.display = 'none';
        if (codGroup) codGroup.style.display = 'none';

        // Show relevant group
        if (method === 'credit-card' || method === 'debit-card') {
            if (cardGroup) {
                cardGroup.style.display = 'block';
                console.log('Card form shown');
            }
        } else if (method === 'upi') {
            if (upiGroup) {
                upiGroup.style.display = 'block';
                console.log('UPI form shown');
            }
            generateUPIQR();
        } else if (method === 'netbanking') {
            if (netbankingGroup) {
                netbankingGroup.style.display = 'block';
                console.log('NetBanking info shown');
            }
        } else if (method === 'cod') {
            if (codGroup) {
                codGroup.style.display = 'block';
                console.log('COD info shown');
            }
        }
    };

    paymentField.addEventListener('change', updatePaymentDetails);
    paymentField.addEventListener('input', updatePaymentDetails);

    // Also regenerate QR when UPI ID changes
    const upiId = document.getElementById('upi_id');
    if (upiId) {
        upiId.addEventListener('change', generateUPIQR);
        upiId.addEventListener('keyup', generateUPIQR);
    }

    console.log('setupPaymentDetailsSection() initialization complete');
    updatePaymentDetails();
}

function generateUPIQR() {
    const upiId = document.getElementById('upi_id');
    const qrContainer = document.getElementById('upi-qr-code');
    if (!upiId || !qrContainer) return;

    const upiValue = upiId.value.trim();
    if (!upiValue) {
        qrContainer.innerHTML = '<p style="color: #999;">Enter your UPI ID to generate QR code</p>';
        return;
    }

    // UPI string format: upi://pay?pa=UPI_ID
    const upiString = encodeURIComponent(`upi://pay?pa=${upiValue}`);
    const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${upiString}`;

    qrContainer.innerHTML = `
        <div style="text-align: center;">
            <img src="${qrCodeUrl}" alt="UPI QR Code" style="max-width: 200px; border-radius: 8px;">
            <p style="margin-top: 10px; color: #666; font-size: 0.85rem;">UPI ID: <strong>${upiValue}</strong></p>
        </div>
    `;
}

function validatePaymentDetails() {
    const method = document.getElementById('payment').value;

    if (method === 'credit-card' || method === 'debit-card') {
        const cardName = document.getElementById('card_name').value.trim();
        const cardNumber = document.getElementById('card_number').value.trim().replace(/\s/g, '');
        const cardMonth = document.getElementById('card_month').value.trim();
        const cardYear = document.getElementById('card_year').value.trim();
        const cardCvv = document.getElementById('card_cvv').value.trim();

        if (!cardName) {
            alert('Please enter cardholder name');
            return false;
        }
        if (!cardNumber || cardNumber.length < 13 || cardNumber.length > 19) {
            alert('Please enter a valid card number');
            return false;
        }
        if (!cardMonth || cardMonth < 1 || cardMonth > 12) {
            alert('Please enter valid month (01-12)');
            return false;
        }
        if (!cardYear || cardYear.length !== 2) {
            alert('Please enter valid year (YY)');
            return false;
        }
        if (!cardCvv || cardCvv.length < 3 || cardCvv.length > 4) {
            alert('Please enter valid CVV');
            return false;
        }
    } else if (method === 'upi') {
        const upiId = document.getElementById('upi_id').value.trim();
        if (!upiId) {
            alert('Please enter your UPI ID');
            return false;
        }
        if (!/^[a-zA-Z0-9._-]+@[a-zA-Z]+$/.test(upiId)) {
            alert('Please enter a valid UPI ID (e.g., yourname@upi)');
            return false;
        }
    }

    return true;
}

function logoutUser() {
    localStorage.removeItem('FASHIOFY_currentUser');
    localStorage.removeItem('FASHIOFY_userDetails');
    window.location.reload();
}

// ========== CART PAGE RENDERING ==========
function renderCart() {
    const emptyDiv = document.getElementById('cart-empty');
    const contentDiv = document.getElementById('cart-content');
    const cartGrid = document.getElementById('cart-grid');
    const cartCountDisplay = document.getElementById('cart-count-display');

    if (cart.length === 0) {
        emptyDiv.style.display = 'block';
        contentDiv.style.display = 'none';
        return;
    }

    emptyDiv.style.display = 'none';
    contentDiv.style.display = 'block';
    cartCountDisplay.innerText = cart.reduce((s, i) => s + i.qty, 0);
    cartGrid.innerHTML = '';

    cart.forEach((item, index) => {
        // Find product image from DB
        const product = Object.values(products).find(p => p.name === item.name);
        const img = product ? product.image : 'images/placeholder.jpg';

        const row = document.createElement('div');
        row.className = 'cart-item';
        row.innerHTML = `
            <img src="${img}" alt="${item.name}">
            <div class="cart-item-info">
                <h3>${item.name}</h3>
                <p>Size: ${item.size}</p>
                <p class="price">₹${item.price}</p>
            </div>
            <div class="cart-item-actions">
                <div class="qty-control">
                    <button onclick="updateQty(${index}, -1)">-</button>
                    <span>${item.qty}</span>
                    <button onclick="updateQty(${index}, 1)">+</button>
                </div>
                <button class="remove-btn" onclick="removeFromCart(${index})">Remove</button>
            </div>
        `;
        cartGrid.appendChild(row);
    });

    calculateTotals();
}

function updateQty(index, delta) {
    cart[index].qty += delta;
    if (cart[index].qty < 1) cart[index].qty = 1;
    localStorage.setItem('FASHIOFY_cart', JSON.stringify(cart));
    renderCart();
    updateBadge();
}

function removeFromCart(index) {
    const removedItem = cart[index];

    // Record cancellation in database if user is logged in
    const userId = localStorage.getItem('FASHIOFY_userId');
    if (userId && removedItem) {
        recordCancellation(removedItem, 'Removed from cart');
    }

    cart.splice(index, 1);
    localStorage.setItem('FASHIOFY_cart', JSON.stringify(cart));
    renderCart();
    updateBadge();
}

function recordCancellation(item, reason = 'User cancelled') {
    const userId = localStorage.getItem('FASHIOFY_userId');
    if (!userId) return;

    const formData = new FormData();
    formData.append('user_id', userId);
    formData.append('product_name', item.name);
    formData.append('quantity', item.qty || 1);
    formData.append('price', item.price);
    formData.append('size', item.size || '');
    formData.append('reason', reason);

    fetch('cancel_handler.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Cancellation recorded:', data.cancellation_id);
            } else {
                console.error('Failed to record cancellation:', data.message);
            }
        })
        .catch(error => {
            console.error('Cancellation recording error:', error);
        });
}

function clearCart() {
    cart = [];
    localStorage.setItem('FASHIOFY_cart', JSON.stringify(cart));
    renderCart();
    updateBadge();
}

function calculateTotals() {
    const summaryDiv = document.getElementById('cart-summary');
    const subtotal = cart.reduce((s, i) => s + (i.price * i.qty), 0);
    const tax = subtotal * 0.18;
    const total = subtotal + tax;

    summaryDiv.innerHTML = `
        <div class="summary-line"><span>Subtotal</span><span>₹${subtotal.toFixed(2)}</span></div>
        <div class="summary-line"><span>GST (18%)</span><span>₹${tax.toFixed(2)}</span></div>
        <div class="summary-line total"><span>Total</span><span>₹${total.toFixed(2)}</span></div>
    `;
}

function addOrderToHistory(order) {
    const orders = JSON.parse(localStorage.getItem('FASHIOFY_orders') || '[]');
    orders.push(order);
    localStorage.setItem('FASHIOFY_orders', JSON.stringify(orders));
}

function checkout() {
    window.location.href = 'checkout.php';
}

// ========== PRODUCT DETAILS LOGIC ==========
function loadProductDetails() {
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');
    const p = products[id];

    if (!p) {
        document.querySelector('.product-details-container').innerHTML = '<h2>Product not found</h2><a href="index.php">Back Home</a>';
        return;
    }

    document.getElementById('product-name').innerText = p.name;
    document.getElementById('product-price').innerText = p.price;
    document.getElementById('product-description').innerText = p.description;
    document.getElementById('product-image').src = p.image;

    const sizeOptions = document.getElementById('size-options');
    sizeOptions.innerHTML = '';
    const sizeSelect = document.getElementById('size-select');
    sizeSelect.innerHTML = '';

    p.sizes.forEach((s, idx) => {
        // Compatibility hidden select
        const opt = document.createElement('option');
        opt.value = s;
        opt.textContent = s;
        sizeSelect.appendChild(opt);

        // Visual buttons
        const btn = document.createElement('button');
        btn.textContent = s;
        btn.style.padding = '12px 20px';
        btn.style.border = '1px solid #ddd';
        btn.style.background = 'white';
        btn.style.borderRadius = '4px';
        btn.style.cursor = 'pointer';
        btn.style.fontWeight = '700';
        btn.style.fontSize = '0.85rem';
        btn.style.transition = 'all 0.2s ease';

        btn.onclick = () => {
            document.querySelectorAll('#size-options button').forEach(b => {
                b.style.background = 'white';
                b.style.color = '#111';
                b.style.borderColor = '#ddd';
            });
            btn.style.background = '#111';
            btn.style.color = 'white';
            btn.style.borderColor = '#111';
            sizeSelect.value = s;
        };

        // Select first size by default
        if (idx === 0) {
            btn.click();
        }

        sizeOptions.appendChild(btn);
    });

    // Related products (random 4 matches)
    const allOfCategory = Object.values(products).filter(item => item.category === p.category && item.id !== p.id);
    const shuffled = allOfCategory.sort(() => 0.5 - Math.random()).slice(0, 4);
    renderRelatedProducts(p.category, shuffled);

    // Track recently viewed
    trackViewedItem(id);
    renderRecentlyViewed();

    // Fetch Reviews
    fetchReviews(id);
    setupReviewStars();
}

function renderRelatedProducts(category, productsToList) {
    const grid = document.getElementById('related-product-grid');
    if (!grid) return;
    grid.innerHTML = '';

    productsToList.forEach(p => {
        const card = document.createElement('div');
        card.className = 'product-card';
        card.innerHTML = `
            <div style="position: relative;">
                <button class="btn-wishlist" onclick="addToWishlist(${p.id}, event)" style="position: absolute; top: 10px; left: 10px; background: rgba(255, 255, 255, 0.9); border: none; border-radius: 50%; color: #e74c3c; width: 35px; height: 35px; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 10; transition: transform 0.2s ease;">❤️</button>
                <a href="product-details.php?id=${p.id}" class="img-box" style="display: block;">
                    <img src="${p.image}" alt="${p.name}">
                </a>
            </div>
            <div class="product-info">
                <a href="product-details.php?id=${p.id}" style="text-decoration: none; color: inherit;">
                    <h3>${p.name}</h3>
                </a>
                <p class="price">₹${p.price}.00</p>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <button class="btn" onclick="addToCart(this, '${p.name}', ${p.price})">Add to Bag</button>
                </div>
            </div>
        `;
        grid.appendChild(card);
    });
    setupProductLinks();
}

// ========== RECENTLY VIEWED LOGIC ==========
function trackViewedItem(productId) {
    let viewed = JSON.parse(localStorage.getItem('FASHIOFY_viewedItems') || '[]');
    viewed = viewed.filter(id => id.toString() !== productId.toString());
    viewed.unshift(productId);
    viewed = viewed.slice(0, 10); // Keep last 10
    localStorage.setItem('FASHIOFY_viewedItems', JSON.stringify(viewed));
}

function renderRecentlyViewed() {
    const section = document.getElementById('recent-views-section');
    const grid = document.getElementById('recently-viewed-grid');
    if (!grid || !section) return;

    const viewedIds = JSON.parse(localStorage.getItem('FASHIOFY_viewedItems') || '[]');
    const currentId = new URLSearchParams(window.location.search).get('id');
    const filteredIds = viewedIds.filter(id => id.toString() !== currentId.toString());

    if (filteredIds.length === 0) {
        section.style.display = 'none';
        return;
    }

    section.style.display = 'block';
    grid.innerHTML = '';
    
    filteredIds.forEach(id => {
        const p = products[id];
        if (!p) return;
        const card = document.createElement('div');
        card.className = 'product-card';
        card.innerHTML = `
            <div style="position: relative;">
                <button class="btn-wishlist" onclick="addToWishlist(${p.id}, event)" style="position: absolute; top: 10px; left: 10px; background: rgba(255, 255, 255, 0.9); border: none; border-radius: 50%; color: #e74c3c; width: 35px; height: 35px; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 10; transition: transform 0.2s ease;">❤️</button>
                <a href="product-details.php?id=${p.id}" class="img-box" style="display: block;">
                    <img src="${p.image}" alt="${p.name}">
                </a>
            </div>
            <div class="product-info">
                <a href="product-details.php?id=${p.id}" style="text-decoration: none; color: inherit;">
                    <h3>${p.name}</h3>
                </a>
                <p class="price">₹${p.price}.00</p>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <button class="btn" onclick="addToCart(this, '${p.name}', ${p.price})">Add to Bag</button>
                </div>
            </div>
        `;
        grid.appendChild(card);
    });
}

// ========== REVIEWS LOGIC ==========
function setupReviewStars() {
    const stars = document.querySelectorAll('.star-rating .star');
    const ratingInput = document.getElementById('review-rating');
    const form = document.getElementById('review-form');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const rating = star.getAttribute('data-rating');
            ratingInput.value = rating;
            
            stars.forEach(s => {
                if (s.getAttribute('data-rating') <= rating) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });

        star.addEventListener('mouseenter', () => {
            const rating = star.getAttribute('data-rating');
            stars.forEach(s => {
                if (s.getAttribute('data-rating') <= rating) {
                    s.style.color = '#f1c40f';
                }
            });
        });

        star.addEventListener('mouseleave', () => {
            stars.forEach(s => s.style.color = '');
        });
    });

    if (form) {
        form.onsubmit = (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const productId = new URLSearchParams(window.location.search).get('id');
            formData.append('product_id', productId);

            fetch('review_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Thank you for your review!');
                    form.reset();
                    // Reset stars
                    stars.forEach(s => s.classList.remove('active'));
                    stars[4].click(); // Default to 5 stars
                    fetchReviews(productId);
                } else {
                    alert('Error: ' + data.message);
                }
            });
        };
    }
}

function fetchReviews(productId) {
    const list = document.getElementById('reviews-list');
    if (!list) return;

    fetch(`review_handler.php?product_id=${productId}`)
    .then(res => res.json())
    .then(data => {
        if (data.reviews && data.reviews.length > 0) {
            list.innerHTML = '';
            data.reviews.forEach(rev => {
                const div = document.createElement('div');
                div.className = 'review-item';
                div.innerHTML = `
                    <div class="review-header">
                        <div class="review-user-info">
                            <div class="review-avatar">${rev.user_name.charAt(0).toUpperCase()}</div>
                            <div>
                                <div style="font-weight:700;">${rev.user_name}</div>
                                <div class="review-meta">${new Date(rev.created_at).toLocaleDateString()}</div>
                            </div>
                        </div>
                        <div class="review-rating">${'★'.repeat(rev.rating)}${'☆'.repeat(5-rev.rating)}</div>
                    </div>
                    <p class="review-comment">${rev.comment}</p>
                `;
                list.appendChild(div);
            });
        } else {
            list.innerHTML = '<p style="color: #999; font-style: italic; text-align: center; padding: 40px;">No reviews yet. Be the first to share your thoughts!</p>';
        }
    });
}

function addToCartFromDetails() {
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');
    const p = products[id];
    const size = document.getElementById('size-select').value;

    if (!size) {
        alert('Please select a size first');
        return;
    }

    let existing = cart.find(it => it.name === p.name && it.size === size);
    if (existing) {
        existing.qty++;
    } else {
        cart.push({ name: p.name, price: p.price, size: size, qty: 1 });
    }

    localStorage.setItem('FASHIOFY_cart', JSON.stringify(cart));
    updateBadge();

    // Show "Toast" Notification (Redesigned)
    const toast = document.getElementById('toast');
    toast.innerHTML = `
        <div style="display:flex; align-items:center; gap:15px; text-align:left;">
            <div style="font-size:1.5rem;">🛍️</div>
            <div>
                <div style="font-weight:800; text-transform:uppercase; font-size:0.75rem; letter-spacing:1px; margin-bottom:2px; color:var(--accent);">Added to Bag</div>
                <div style="font-size:0.85rem; font-weight:600;">${p.name}</div>
                <div style="font-size:0.75rem; opacity:0.8;">Size: ${size}</div>
            </div>
        </div>
    `;
    toast.className = "show";
    setTimeout(() => toast.className = "", 4000);
}


function checkStock() {
    const pincode = document.getElementById('pincode-input').value.replace(/\D/g, '');
    const size = document.getElementById('size-select').value;
    const statusDiv = document.getElementById('stock-status');

    if (!pincode || pincode.length !== 6) {
        statusDiv.innerHTML = '<span style="color: #e74c3c;">Please enter a valid 6-digit pincode.</span>';
        return;
    }

    if (!size) {
        statusDiv.innerHTML = '<span style="color: #e74c3c;">Please select a size first.</span>';
        return;
    }

    // Simulate stock check (demo logic)
    const stockHash = (pincode + size).split('').reduce((a, b) => a + b.charCodeAt(0), 0);
    const stockLevel = stockHash % 10; // 0-9 items

    if (stockLevel === 0) {
        statusDiv.innerHTML = '<span style="color: #e74c3c;">❌ Out of stock in your area.</span>';
    } else if (stockLevel <= 3) {
        statusDiv.innerHTML = `<span style="color: #f39c12;">⚠️ Only ${stockLevel} item(s) left in stock.</span>`;
    } else {
        statusDiv.innerHTML = `<span style="color: #27ae60;">✅ In stock (${stockLevel} items available).</span>`;
    }
}

// ========== CHECKOUT LOGIC ==========
function renderCheckoutSummary() {
    console.log('renderCheckoutSummary() called');
    const summaryItems = document.getElementById('summary-items');
    const summaryTotal = document.getElementById('summary-total');
    const pincodeField = document.getElementById('pincode');
    const cityField = document.getElementById('city');
    const stateField = document.getElementById('state');
    const pincodeError = document.getElementById('pincode-error');

    let pincodeLookupTimer = null;
    if (pincodeField) {
        pincodeField.addEventListener('input', function () {
            const code = this.value.replace(/\D/g, '');
            cityField.value = '';
            stateField.value = '';
            if (pincodeError) pincodeError.innerText = '';

            clearTimeout(pincodeLookupTimer);
            if (code.length !== 6) return;

            pincodeLookupTimer = setTimeout(() => {
                fetch(`https://api.postalpincode.in/pincode/${code}`)
                    .then(response => response.json())
                    .then(data => {
                        if (!Array.isArray(data) || data.length === 0) {
                            throw new Error('Invalid API response');
                        }
                        const result = data[0];
                        if (result.Status !== 'Success' || !result.PostOffice || result.PostOffice.length === 0) {
                            throw new Error('Pincode not found');
                        }
                        const office = result.PostOffice[0];
                        cityField.value = office.District || office.Block || office.Region || '';
                        stateField.value = office.State || '';
                        if (pincodeError) pincodeError.innerText = '';
                    })
                    .catch(() => {
                        cityField.value = '';
                        stateField.value = '';
                        if (pincodeError) pincodeError.innerText = 'Pincode not found. Please verify the number.';
                    });
            }, 400);
        });
    }

    if (cart.length === 0) {
        window.location.href = 'cart.php';
        return;
    }

    summaryItems.innerHTML = '';
    let subtotal = 0;
    cart.forEach(item => {
        const itemTotal = item.price * item.qty;
        subtotal += itemTotal;
        const div = document.createElement('div');
        div.style.display = 'flex';
        div.style.justifyContent = 'space-between';
        div.style.marginBottom = '15px';
        div.style.alignItems = 'center';
        div.innerHTML = `
            <div style="display:flex; flex-direction:column;">
                <span style="font-weight:700; font-size:0.9rem;">${item.name}</span>
                <span style="font-size:0.8rem; color:#888;">Size: ${item.size} • Qty: ${item.qty}</span>
            </div>
            <span style="font-weight:700; color:#111;">₹${itemTotal}</span>
        `;
        summaryItems.appendChild(div);
    });

    const tax = subtotal * 0.18;
    const finalTotal = subtotal + tax;

    const taxDiv = document.createElement('div');
    taxDiv.style.display = 'flex';
    taxDiv.style.justifyContent = 'space-between';
    taxDiv.style.marginTop = '20px';
    taxDiv.style.paddingTop = '15px';
    taxDiv.style.borderTop = '1px dashed #ddd';
    taxDiv.innerHTML = `
        <span style="color:#666; font-size:0.9rem;">GST (18%)</span>
        <span style="color:#666; font-size:0.9rem;">₹${tax.toFixed(2)}</span>
    `;
    summaryItems.appendChild(taxDiv);

    summaryTotal.innerText = `₹${finalTotal.toFixed(2)}`;

    // Setup form submit
    const form = document.getElementById('checkout-form');

    // Pre-fill user details if logged in
    const userDetails = JSON.parse(localStorage.getItem('FASHIOFY_userDetails') || 'null');
    if (userDetails) {
        document.getElementById('email').value = userDetails.email || '';
        document.getElementById('mobile').value = userDetails.phone || '';
        document.getElementById('name').value = userDetails.name || document.getElementById('name').value;
    }

    if (pincodeField && cityField && stateField && pincodeField.value.length === 6) {
        const event = new Event('input');
        pincodeField.dispatchEvent(event);
    }

    // Setup payment method forms (card details, UPI, etc)
    setupPaymentDetailsSection();

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Validate payment details first
        if (!validatePaymentDetails()) {
            return;
        }

        // Visual processing feedback
        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerText;
        btn.innerText = "Processing Order...";
        btn.disabled = true;

        // Collect order details
        const formData = new FormData(form);
        const userId = localStorage.getItem('FASHIOFY_userId');
        const paymentMethod = formData.get('payment');

        // Collect payment details based on method
        let paymentDetails = '';
        if (paymentMethod === 'credit-card' || paymentMethod === 'debit-card') {
            paymentDetails = JSON.stringify({
                card_name: document.getElementById('card_name').value,
                card_last4: document.getElementById('card_number').value.slice(-4)
            });
        } else if (paymentMethod === 'upi') {
            paymentDetails = document.getElementById('upi_id').value;
        }

        const orderData = {
            user_id: userId,
            name: formData.get('name'),
            email: formData.get('email'),
            mobile: formData.get('mobile'),
            pincode: formData.get('pincode'),
            street: formData.get('street'),
            city: formData.get('city'),
            state: formData.get('state'),
            payment_method: paymentMethod,
            payment_details: paymentDetails,
            items: cart,
            subtotal: subtotal
        };


        // Send to backend
        fetch('process-checkout.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(orderData)
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Add to order history
                    addOrderToHistory({
                        id: data.tracking_id,
                        date: new Date().toLocaleString(),
                        status: 'Placed',
                        items: orderData.items,
                        total: (orderData.subtotal * 1.18).toFixed(2),
                        email: orderData.email,
                        mobile: orderData.mobile,
                        isLocal: false
                    });

                    cart = [];
                    localStorage.setItem('FASHIOFY_cart', JSON.stringify(cart));
                    window.location.href = `order-tracking.php?id=${data.tracking_id}&success=1`;
                } else {
                    console.warn('Checkout failed server-side, using fallback:', data.message);
                    // If server error, fallback to local and continue
                    const fallbackTrackingId = 'LOCAL-' + Date.now();
                    addOrderToHistory({
                        id: fallbackTrackingId,
                        date: new Date().toLocaleString(),
                        status: 'Placed',
                        items: orderData.items,
                        total: (orderData.subtotal * 1.18).toFixed(2),
                        email: orderData.email,
                        mobile: orderData.mobile,
                        isLocal: true
                    });

                    cart = [];
                    localStorage.setItem('FASHIOFY_cart', JSON.stringify(cart));
                    window.location.href = `order-tracking.php?id=${fallbackTrackingId}&success=1&local=1`;
                }
            })
            .catch(err => {
                console.error('Checkout error:', err);

                // Fallback to local order if backend is not reachable
                const fallbackTrackingId = 'LOCAL-' + Date.now();
                addOrderToHistory({
                    id: fallbackTrackingId,
                    date: new Date().toLocaleString(),
                    status: 'Placed',
                    items: orderData.items,
                    total: (orderData.subtotal * 1.18).toFixed(2),
                    email: orderData.email,
                    mobile: orderData.mobile,
                    isLocal: true
                });

                // Clear cart and redirect to tracking with fallback flag
                cart = [];
                localStorage.setItem('FASHIOFY_cart', JSON.stringify(cart));
                window.location.href = `order-tracking.php?id=${fallbackTrackingId}&success=1&local=1`;

                btn.innerText = originalText;
                btn.disabled = false;
            });
    });
}


// (Duplicate search results logic removed)

// ========== WISHLIST PAGE LOGIC ==========
function renderWishlist() {
    const grid = document.getElementById('wishlist-grid');
    const empty = document.getElementById('wishlist-empty');
    const content = document.getElementById('wishlist-content');
    const count = document.getElementById('wishlist-count');

    if (wishlist.length === 0) {
        empty.style.display = 'block';
        content.style.display = 'none';
        return;
    }

    empty.style.display = 'none';
    content.style.display = 'block';
    count.innerText = wishlist.length;
    grid.innerHTML = '';

    wishlist.forEach(id => {
        const p = products[id];
        if (!p) return;
        const card = document.createElement('div');
        card.className = 'product-card';
        card.innerHTML = `
            <div class="img-box"><img src="${p.image}" alt="${p.name}"></div>
            <div class="product-info">
                <h3>${p.name}</h3>
                <p class="price">₹${p.price}</p>
                <div style="display:flex; gap:10px;">
                    <button class="btn" onclick="addToCart(this, '${p.name}', ${p.price})">Add to Bag</button>
                    <button class="btn" style="background:#e74c3c;" onclick="removeFromWishlist(${id})">Remove</button>
                </div>
            </div>
        `;
        grid.appendChild(card);
    });
    setupProductLinks();
}

function clearWishlist() {
    wishlist = [];
    localStorage.setItem('FASHIOFY_wishlist', JSON.stringify(wishlist));
    renderWishlist();
}

/**
 * Toggle Product Info Accordions
 * @param {HTMLElement} header - The header element of the accordion
 */
function toggleAccordion(header) {
    const item = header.parentElement;
    const content = header.nextElementSibling;
    const allItems = document.querySelectorAll('.accordion-item');
    
    // Close other items
    allItems.forEach(i => {
        if (i !== item) {
            i.classList.remove('active');
            i.querySelector('.accordion-content').style.maxHeight = null;
        }
    });

    // Toggle current item
    item.classList.toggle('active');
    if (item.classList.contains('active')) {
        content.style.maxHeight = content.scrollHeight + "px";
    } else {
        content.style.maxHeight = null;
    }
}

