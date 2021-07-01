package net.notejam.spring.user;

import static org.junit.Assert.assertEquals;
import static org.junit.Assert.assertFalse;
import static org.junit.Assert.assertTrue;

import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.test.context.support.WithMockUser;
import org.springframework.test.context.junit4.SpringJUnit4ClassRunner;

import net.notejam.spring.test.IntegrationTest;

/**
 * An integration test for the UserService.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@IntegrationTest
@RunWith(SpringJUnit4ClassRunner.class)
public class UserServiceTest {

    @Autowired
    private UserService service;

    /**
     * Tests getAuthenticatedUser() returns the authenticated user.
     */
    @Test
    @WithMockUser("test@example.net")
    public void testGetAuthenticatedUser() {
        service.signUp("test@example.net", "password");
        assertEquals("test@example.net", service.getAuthenticatedUser().getEmail());
    }

    /**
     * Tests isEmailRegistered() and signUp().
     */
    @Test
    public void testSignUp() {
        String email = "test@example.net";
        assertFalse(service.isEmailRegistered(email));

        service.signUp(email, "password");
        assertTrue(service.isEmailRegistered(email));
    }

}
