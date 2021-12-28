<?php
    $title = "Login";
    include "header.php";
    guestOnlyPage();
    $currentSection = "login";
    if(isset($_POST))
    {
        array_filter($_POST,'processPosts');
        if($_POST['submit'] == 'Login')
        {
            $currentSection = "login";
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) !== false
                && filter_var($_POST['password'],FILTER_VALIDATE_REGEXP,["options" => [ "regexp" => "/^[\w\d]{8,}$/"]]) !== false)
            {
                if(attemptUserLogin($_POST['email'],$_POST['password']))
                {
                    $successMessages[] = "Login successful. Redirecting...";
                }
                else
                {
                    $errorMessages[] = "Your login credentials are not working";
                }
            }
            else
            {
                $errorMessages[] = "Email or password invalid. Please try again.";
            }
        }
        else if($_POST['submit'] == 'Register')
        {
            $currentSection = "register";
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
                && filter_var($_POST['password'],FILTER_VALIDATE_REGEXP,["options" => [ "regexp" => "/^[\w\d]{8,}$/"]])
                && filter_var($_POST['confirm_password'],FILTER_VALIDATE_REGEXP,["options" => [ "regexp" => "/^[\w\d]{8,}$/"]])
                && $_POST['password'] == $_POST['confirm_password'])
            {
                $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $_POST['password'] = null;
                $_POST['confirm_password'] = null;
                if(registerUser($_POST['email'],$hash))
                {
                    $successMessages[] = "Registration successful. You may now log in.";
                    $currentSection = "login";
                }
                else
                {
                    $errorMessages[] = "A user with the this email already exists! Sign in, or try a different email.";
                }
            }
            else
            {
                $errorMessages[] = "Please make sure that your email is valid and that your passwords match.";
            }
        }
    }
?>
            <div class="row align-items-start gx-5">
                <div class="col-md-6 offset-md-3" id="loginSection" <?php if($currentSection == "register") echo "style='display:none;'"; ?>>
                    <h1 class="text-center">Login</h1>
                        <form method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your registered Email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" minlength="8" placeholder="Enter your password" required>
                            </div>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-primary btn-lg" name="submit" value="Login"/>
                            </div>
                            <div class="mb-3">
                                <a href="#" onclick="openRegister()">Don't have an account? Register Now</a>
                            </div>
                        </form>
                </div>
                <div class="col-md-6 offset-md-3" id="registerSection" <?php if($currentSection == "login") echo "style='display:none;'"; ?>>
                    <h1 class="text-center">Register</h1>
                        <form method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" minlength="8" placeholder="Choose your desired password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" minlength="8" placeholder="Enter your password again" required>
                            </div>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-primary btn-lg" name="submit" value="Register"/>
                            </div>
                            <div class="mb-3">
                                <a href="#" onclick="openLogin()">Already have an account? Login now!</a>
                            </div>
                        </form>
                </div>
            </div>

<?php
    include "footer.php";
?>
