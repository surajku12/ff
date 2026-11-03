<?php
$page_title = "My Profile | FASHIOFY";
include 'includes/header.php';

// Authentication Check
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php?redirect=profile.php");
    exit();
}

include 'includes/db.php';

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$_SESSION['user_email']]);
    $user = $stmt->fetch();
} catch (Exception $e) {
    $error = "Database error: " . $e->getMessage();
}
?>

<div class="page-banner" style="background-image: url('images/suit%20(women).jpg');">
    <h1>My Profile</h1>
</div>

<main class="container section-padding">
    <div class="profile-container">
        <div class="profile-sidebar">
            <div class="profile-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <h3><?php echo htmlspecialchars(explode('@', $_SESSION['user_email'])[0]); ?></h3>
            <p class="user-status">Premium Member</p>
            <nav class="profile-nav">
                <a href="profile.php" class="active"><i class="fas fa-id-card"></i> Personal Details</a>
                <a href="order-history.php"><i class="fas fa-box-open"></i> My Orders</a>
                <a href="wishlist.php"><i class="fas fa-heart"></i> My Wishlist</a>
                <a href="logout.php" class="logout-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </div>

        <div class="profile-main">
            <div class="profile-card">
                <h2>Account Details</h2>
                <div class="details-grid">
                    <div class="detail-group">
                        <label>Email Address</label>
                        <p><?php echo htmlspecialchars($user['email']); ?></p>
                    </div>
                    <?php if($user['phone']): ?>
                    <div class="detail-group">
                        <label>Phone Number</label>
                        <p><?php echo htmlspecialchars($user['phone']); ?></p>
                    </div>
                    <?php endif; ?>
                    <div class="detail-group">
                        <label>Member Since</label>
                        <p><?php echo date('M d, Y', strtotime($user['created_at'])); ?></p>
                    </div>
                    <div class="detail-group">
                        <label>Login Count</label>
                        <p><?php echo $user['login_count']; ?></p>
                    </div>
                </div>
                <button class="btn btn-outline" onclick="alert('Profile editing coming soon!')">Edit Profile</button>
            </div>

            <div class="profile-card">
                <h2>Shipping Address</h2>
                <p class="empty-state">No address saved yet.</p>
                <button class="btn btn-outline" onclick="alert('Address management coming soon!')">Add New Address</button>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
