<?php
$page_title = "Login | FASHIOFY";
include 'includes/header.php';
?>

<div id="user-profile" style="max-width:900px; margin:20px auto; display:none;"></div>

<div class="login-container" style="min-height: 90vh; display: flex; align-items: center; justify-content: center; background: #fdfdfd; padding: 40px 20px;">
    <div class="login-box" style="background: white; width: 100%; max-width: 480px; padding: 60px; border-radius: 4px; box-shadow: 0 40px 100px rgba(0,0,0,0.06); border: 1px solid #eee;">
        <div class="login-header" style="text-align: center; margin-bottom: 50px;">
            <h1 style="font-family:'Playfair Display', serif; font-size: 2.8rem; letter-spacing: -1px; margin-bottom: 10px;">Welcome Back</h1>
            <p style="color: #888; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 2px;">Sign in to continue</p>
        </div>

        <form onsubmit="return validateLogin()" style="display: flex; flex-direction: column; gap: 25px;">
            <div class="form-group">
                <label style="display: block; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; color: #111; margin-bottom: 12px;">Email Address</label>
                <input type="email" id="email" placeholder="shop@fashiofy.com" required 
                       style="width: 100%; padding: 18px; border: 1.5px solid #eee; border-radius: 4px; font-size: 1rem; transition: border-color 0.3s ease; outline: none;">
                <div class="form-error" id="email-error" style="color: #e74c3c; font-size: 0.8rem; margin-top: 5px; font-weight: 600;"></div>
            </div>

            <div class="form-group">
                <label style="display: block; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; color: #111; margin-bottom: 12px;">Password</label>
                <input type="password" id="password" placeholder="••••••••" required 
                       style="width: 100%; padding: 18px; border: 1.5px solid #eee; border-radius: 4px; font-size: 1rem; transition: border-color 0.3s ease; outline: none;">
                <div class="form-error" id="password-error" style="color: #e74c3c; font-size: 0.8rem; margin-top: 5px; font-weight: 600;"></div>
            </div>

            <div class="form-group">
                <label style="display: block; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; color: #111; margin-bottom: 12px;">Phone Number</label>
                <input type="tel" id="phone" placeholder="98765 43210" 
                       style="width: 100%; padding: 18px; border: 1.5px solid #eee; border-radius: 4px; font-size: 1rem; transition: border-color 0.3s ease; outline: none;">
                <div class="form-error" id="phone-error" style="color: #e74c3c; font-size: 0.8rem; margin-top: 5px; font-weight: 600;"></div>
            </div>

            <div class="remember-forgot" style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
                <label style="display: flex; align-items: center; gap: 8px; color: #666; cursor: pointer;">
                    <input type="checkbox" style="accent-color: #111;"> Remember me
                </label>
                <a href="#" style="color: #111; text-decoration: none; font-weight: 700; border-bottom: 1.5px solid #eee;">Forgot password?</a>
            </div>

            <button type="submit" class="login-btn" 
                    style="width: 100%; padding: 20px; background: #111; color: white; border: none; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 0.3s ease; margin-top: 15px;">
                Secure Sign In
            </button>
        </form>

        <div class="login-divider" style="text-align: center; margin: 40px 0; color: #ddd; position: relative;">
            <span style="background: white; padding: 0 20px; position: relative; z-index: 2; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">Or Connect With</span>
            <div style="position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: #eee; z-index: 1;"></div>
        </div>

        <div class="social-login" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <button type="button" id="google-login-btn" onclick="simulateSocialLogin('Google')" class="social-btn" style="padding: 15px; background: white; border: 1px solid #eee; border-radius: 4px; font-weight: 700; font-size: 0.85rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; transition: all 0.3s ease;">
                <img src="https://cdn-icons-png.flaticon.com/512/300/300221.png" alt="Google" style="width: 16px; height: 16px;"> <span>Sign up with Google</span>
            </button>
            <button type="button" id="facebook-login-btn" onclick="simulateSocialLogin('Facebook')" class="social-btn" style="padding: 15px; background: white; border: 1px solid #eee; border-radius: 4px; font-weight: 700; font-size: 0.85rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; transition: all 0.3s ease;">
                <img src="https://cdn-icons-png.flaticon.com/512/5968/5968764.png" alt="Facebook" style="width: 16px; height: 16px;"> <span>Sign up with Facebook</span>
            </button>
        </div>

        <div class="signup-link" style="text-align: center; margin-top: 50px; font-size: 0.9rem; color: #666;">
            New to FASHIOFY? <a href="#" onclick="return validateLogin()" style="color: #111; text-decoration: none; font-weight: 800; border-bottom: 2px solid #c5a059;">Create Account</a>
        </div>
    </div>
</div>

    <div id="toast">Form processed!</div>

    <script src="script.js"></script>
</body>

</html>

<?php include 'includes/footer.php'; ?>
