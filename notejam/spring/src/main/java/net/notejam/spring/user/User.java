package net.notejam.spring.user;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.validation.constraints.NotNull;

import org.springframework.data.jpa.domain.AbstractPersistable;
import org.springframework.security.crypto.password.PasswordEncoder;

/**
 * The user.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Entity
public class User extends AbstractPersistable<Integer> {

    private static final long serialVersionUID = -7874055769861590146L;

    /**
     * The email address.
     */
    @NotNull
    @Column(unique = true)
    private String email;

    /**
     * The password.
     */
    @NotNull
    private String password;

    /**
     * Sets the password.
     *
     * The password should be persisted as an encoded string by an
     * {@link PasswordEncoder}.
     *
     * @param password
     *            The password.
     */
    public void setPassword(final String password) {
        this.password = password;
    }

    /**
     * Returns the encoded password.
     *
     * Use a {@link PasswordEncoder} to check authentication.
     *
     * @return The encoded password.
     */
    public String getPassword() {
        return this.password;
    }

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
     * @param email
     *            The email address.
     */
    public void setEmail(final String email) {
        this.email = email;
    }

}
