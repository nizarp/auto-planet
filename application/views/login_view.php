
<div id="login-box">   
    <h1>Please Sign In</h1>
    <div class="error-msg"><?php echo validation_errors(); ?></div>
    <?php echo form_open('verifylogin'); ?>
    <p>
      <label for="username">Username:</label>
      <input type="text" id="username" id="username" name="username"/>
    </p>
    <p>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password"/>
    </p>
    <p align="center"><input type="submit" value="Sign In" class="btn" /></p>
    </form>
</div>


