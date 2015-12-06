package net.notejam.spring.user.signup;

import javax.validation.constraints.NotNull;
import javax.validation.constraints.Size;

import org.hibernate.validator.constraints.Email;
import org.hibernate.validator.constraints.NotEmpty;

import de.malkusch.validation.constraints.EqualProperties;
import net.notejam.spring.user.constraints.Password;
import net.notejam.spring.user.signup.constraints.UniqueEmail;

/**
 * Sign up form model.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@EqualProperties(value = { "repeatedPassword", "password" }, violationOnPropery = true)
public class Signup {

    /**
     * The email address.
     */
    @NotEmpty
    @Email
    @UniqueEmail
    @Size(max = 75)
    private String email;

    /**
     * The repeated password.
     */
    @NotNull
    private String repeatedPassword;

    /**
     * The password.
     */
    @Password
    private String password;

    /**
     * Returns the email address.
     *
     * @return The email address.
     */
    public String getEmail() {
        return email;
    }

    /**
     * Sets the email address.
     *
     * @param email The email address.
     */
    public void setEmail(final String email) {
        this.email = email;
    }

    /**
     * Sets the password.
     *
     * @param password The password.
     */
    public void setPassword(final String password) {
        this.password = password;
    }

    /**
     * Returns the password.
     *
     * @return The password.
     */
    public String getPassword() {
        return this.password;
    }

    /**
     * Returns the repeated password.
     *
     * @return The repeated password.
     */
    public String getRepeatedPassword() {
        return repeatedPassword;
    }

    /**
     * Sets the repeated password.
     *
     * @param repeatedPassword The repeated password.
     */
    public void setRepeatedPassword(final String repeatedPassword) {
        this.repeatedPassword = repeatedPassword;
    }

}
