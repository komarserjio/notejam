package net.notejam.spring.user.forgot;

import org.hibernate.validator.constraints.Email;
import org.hibernate.validator.constraints.NotEmpty;

/**
 * The forgot password request.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
public class ForgotPassword {

    /**
     * The email address.
     */
    @Email
    @NotEmpty
    private String email;

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

}
