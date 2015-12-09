package net.notejam.spring.user;

import org.junit.rules.ExternalResource;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

/**
 * A rule for providing a signed up a user.
 *
 * The user will be deleted after each test.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Component
public class SignedUpUserProvider extends ExternalResource {

    /**
     * The user service.
     */
    @Autowired
    private UserService service;

    /**
     * The user repository.
     */
    @Autowired
    private UserRepository repository;

    /**
     * The signed up user.
     */
    private User user;

    /**
     * The email address of the provided user.
     */
    public static final String EMAIL = "test@example.org";
    
    /**
     * The password of the provided user.
     */
    public static final String PASSWORD = "password";

    @Override
    protected void before() {
        user = service.signUp(EMAIL, PASSWORD);
    }

    /**
     * Returns the signed up user.
     * 
     * @return The signed up user.
     */
    public User getUser() {
        return user;
    }

    @Override
    protected void after() {
        repository.delete(user);
    }
}
