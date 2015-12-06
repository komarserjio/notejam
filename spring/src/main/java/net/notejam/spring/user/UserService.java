package net.notejam.spring.user;

import javax.transaction.Transactional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.stereotype.Service;

import net.notejam.spring.security.SecurityService;

/**
 * The user service.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Service
public class UserService {

    /**
     * The user repository.
     */
    @Autowired
    private UserRepository repository;

    /**
     * The security service.
     */
    @Autowired
    private SecurityService securityService;

    /**
     * Checks if an email is already registered.
     *
     * @param email
     *            The email.
     * @return True, if the email is already registered.
     */
    public boolean isEmailRegistered(final String email) {
        return repository.findOneByEmail(email).isPresent();
    }

    /**
     * Returns the authenticated user.
     *
     * @return The currently authenticated user.
     */
    public User getAuthenticatedUser() {
        Authentication authentication = SecurityContextHolder.getContext().getAuthentication();
        String email = authentication.getName();
        return repository.findOneByEmail(email).get();
    }

    /**
     * Sets a new password.
     *
     * @param password
     *            The new password
     */
    @Transactional
    public void changePassword(final String password) {
        User user = getAuthenticatedUser();
        changePassword(user, password);
    }

    /**
     * Sets a new password.
     *
     * @param user
     *            The user
     * @param password
     *            The new password
     */
    @Transactional
    public void changePassword(final User user, final String password) {
        user.setPassword(securityService.encodePassword(password));
        repository.save(user);
    }

    /**
     * Signs up a new user.
     *
     * @param email
     *            The email address
     * @param password
     *            The plain text password
     *
     * @return The signed up user
     */
    @Transactional
    public User signUp(final String email, final String password) {
        User user = new User();
        user.setEmail(email);
        user.setPassword(securityService.encodePassword(password));
        repository.save(user);
        return user;
    }

}
