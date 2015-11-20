package net.notejam.spring.user.signup;

import javax.validation.constraints.NotNull;
import javax.validation.constraints.Size;

import org.hibernate.validator.constraints.Email;
import org.hibernate.validator.constraints.NotEmpty;

import de.malkusch.validation.constraints.EqualProperties;
import net.notejam.spring.user.constraints.Password;
import net.notejam.spring.user.signup.constraints.UniqueEmail;

/**
 * Sign up form model
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@EqualProperties(value = { "repeatedPassword", "password" }, violationOnPropery = true)
public class Signup {

    @NotEmpty
    @Email
    @UniqueEmail
    @Size(max = 75)
    private String email;

    @NotNull
    private String repeatedPassword;

    @Password
    private String password;

    public String getEmail() {
	return email;
    }

    public void setEmail(String email) {
	this.email = email;
    }

    public void setPassword(String password) {
	this.password = password;
    }

    public String getPassword() {
	return this.password;
    }

    public String getRepeatedPassword() {
	return repeatedPassword;
    }

    public void setRepeatedPassword(String repeatedPassword) {
	this.repeatedPassword = repeatedPassword;
    }

}
