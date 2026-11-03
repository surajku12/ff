<?php
$page_title = "Order History | FASHIOFY";
include 'includes/header.php';

// Authentication Check
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php?redirect=order-history.php");
    exit();
}
?>

<div class="tracking-hero" style="background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), url('https://images.unsplash.com/photo-1555529733-0e670560f7e1?auto=format&fit=crop&q=80&w=2000') center/cover; color: white; padding: 100px 0; text-align: center;">
    <h1 style="font-family:'Playfair Display', serif; font-size: 3.5rem; margin-bottom: 15px;">Order History</h1>
    <p style="opacity: 0.9; font-size: 1.1rem; letter-spacing: 1px;">View all your past orders</p>
</div>

<div class="tracking-container" style="max-width: 1000px; margin: -50px auto 100px; padding: 0 20px; position: relative; z-index: 10;">
    <div id="order-history-list" style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.05);">
        <!-- Orders will be populated by JavaScript -->
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const historyContainer = document.getElementById('order-history-list');
    const userEmail = localStorage.getItem('FASHIOFY_currentUser');

    // Get all orders from localStorage (assuming we store them as an array)
    const orders = JSON.parse(localStorage.getItem('FASHIOFY_orders') || '[]');
    const userOrders = userEmail ? orders.filter(order => order.email === userEmail) : orders;

    let infoHtml = '';
    if (!userEmail && orders.length > 0) {
        infoHtml = '<p style="text-align: center; color: #666; margin-bottom: 20px;">You are not logged in. Showing all available orders below. Login to filter to your account.</p>';
    }

    if (orders.length === 0) {
        historyContainer.innerHTML = '<p style="text-align: center; color: #666;">No orders found.</p>';
        return;
    }

    if (userEmail && userOrders.length === 0) {
        historyContainer.innerHTML = '<p style="text-align: center; color: #666;">No orders found for your account. Make a purchase and it will appear here.</p>';
        return;
    }

    let html = infoHtml + '<h3 style="font-size: 1.2rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 25px; color: #111;">' + (userEmail ? 'Your Orders' : 'All Orders') + '</h3>';

    userOrders.forEach(order => {
        // Calculate dynamic status based on time
        const orderDate = new Date(order.date);
        const now = new Date();
        const hoursSinceOrder = (now - orderDate) / (1000 * 60 * 60);

        let status = 'Placed';
        let statusColor = '#f39c12';
        if (hoursSinceOrder > 4) {
            status = 'Delivered';
            statusColor = '#27ae60';
        } else if (hoursSinceOrder > 2) {
            status = 'Shipped';
            statusColor = '#3498db';
        } else if (hoursSinceOrder > 1) {
            status = 'Confirmed';
            statusColor = '#e67e22';
        }

        const trackingLink = order.isLocal ? `order-tracking.php?id=${encodeURIComponent(order.id)}&local=1` : `order-tracking.php?id=${encodeURIComponent(order.id)}`;
        html += `
        <div style="border: 1px solid #eee; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <div>
                    <strong>Order ID: ${order.id}</strong>
                    <br>
                    <small>Date: ${order.date}</small>
                </div>
                <div style="background: #f8f9fa; padding: 8px 15px; border-radius: 20px; font-weight: 600; color: ${statusColor};">${status}</div>
            </div>
            <div>
                <strong>Items:</strong>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    ${order.items.map(item => `<li>${item.name} (Size: ${item.size}, Qty: ${item.qty}) - ₹${item.price * item.qty}</li>`).join('')}
                </ul>
                <strong>Total: ₹${order.total}</strong>
            </div>
            <div style="margin-top: 15px;">
                <a href="${trackingLink}" style="color: #111; text-decoration: none; font-weight: 600;">View Details</a>
            </div>
        </div>
        `;
    });

    historyContainer.innerHTML = html;
});
</script>

<?php include 'includes/footer.php'; ?>