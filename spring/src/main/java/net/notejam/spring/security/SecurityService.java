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
public class SecurityService {

    @Autowired
    private PasswordEncoder passwordEncoder;

    /**
     * Returns true if a password is valid for a user.
     * 
     * @param user
     *            The user
     * @param password
     *            The plain text password
     * @return True if the password is valid.
     */
    public boolean isPasswordValid(User user, String password) {
        return passwordEncoder.matches(password, user.getPassword());
    }

    /**
     * Encodes a plain text password for storage.
     * 
     * @param password
     *            The plain password
     * @return The encoded password
     */
    public String encodePassword(String password) {
        return passwordEncoder.encode(password);
    }

}
