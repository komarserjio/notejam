package net.notejam.spring.security;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

import net.notejam.spring.user.User;

/**
 * Security service.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Service
public final class SecurityService {

    /**
     * The password encoder.
     */
    private final PasswordEncoder encoder;

    /**
     * Sets the password encoder.
     *
     * @param encoder
     *            The password encoder
     */
    @Autowired
    SecurityService(final PasswordEncoder encoder) {
        this.encoder = encoder;
    }

    /**
     * Returns true if a password is valid for a user.
     *
     * @param user
     *            The user
     * @param password
     *            The plain text password
     * @return True if the password is valid.
     */
    public boolean isPasswordValid(final User user, final String password) {
        return encoder.matches(password, user.getPassword());
    }

    /**
     * Encodes a plain text password for storage.
     *
     * @param password
     *            The plain password
     * @return The encoded password
     */
    public String encodePassword(final String password) {
        return encoder.encode(password);
    }

}
