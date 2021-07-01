package net.notejam.spring.security;

import static org.junit.Assert.assertEquals;
import static org.junit.Assert.assertFalse;
import static org.junit.Assert.assertTrue;
import static org.mockito.Mockito.when;

import org.junit.Before;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.mockito.Mock;
import org.mockito.runners.MockitoJUnitRunner;
import org.springframework.security.crypto.password.PasswordEncoder;

import net.notejam.spring.user.User;

/**
 * A test for SecurityService
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@RunWith(MockitoJUnitRunner.class)
public class SecurityServiceTest {

    @Mock
    private PasswordEncoder encoder;

    /**
     * The SUT
     */
    private SecurityService service;

    @Before
    public void setup() {
        service = new SecurityService(encoder);
    }

    /**
     * Tests encode()
     */
    @Test
    public void testEncode() {
        when(encoder.encode("plainPwd")).thenReturn("encodedPwd");
        assertEquals("encodedPwd", service.encodePassword("plainPwd"));
    }

    /**
     * Tests isPasswordValid()
     */
    @Test
    public void testIsPasswordValid() {
        User user = new User();
        user.setPassword("encodedPwd");

        when(encoder.matches("plainPwd", "encodedPwd")).thenReturn(true);

        assertTrue(service.isPasswordValid(user, "plainPwd"));
        assertFalse(service.isPasswordValid(user, "wrong"));
    }
}
