package net.notejam.spring.security.owner;

import static org.mockito.Mockito.when;

import java.util.Optional;

import org.junit.Before;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.mockito.Mock;
import org.mockito.runners.MockitoJUnitRunner;
import org.springframework.security.access.AccessDeniedException;

import net.notejam.spring.pad.Pad;
import net.notejam.spring.user.User;
import net.notejam.spring.user.UserService;

/**
 * A test for PermitOwnerAspect
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@RunWith(MockitoJUnitRunner.class)
public class PermitOwnerAspectTest {

    @Mock
    private UserService userService;

    /**
     * The SUT
     */
    private PermitOwnerAspect aspect;

    @Before
    public void setup() {
        aspect = new PermitOwnerAspect();
        aspect.setUserService(userService);
    }

    /**
     * Tests authorizeReturn() permits Null
     */
    @Test
    public void testAuthorizeReturnShouldPermitNull() {
        aspect.authorizeReturn(null);
        aspect.authorizeReturn(Optional.ofNullable(null));
    }

    /**
     * Tests authorizeReturn() denies anonymous access.
     */
    @Test(expected = AccessDeniedException.class)
    public void testAuthorizeReturnDeniesAnonymous() {
        Pad owned = new Pad();
        owned.setUser(new User());

        when(userService.getAuthenticatedUser()).thenReturn(null);

        aspect.authorizeReturn(owned);
    }

    /**
     * Tests authorizeReturn() denies access to other users.
     */
    @Test(expected = AccessDeniedException.class)
    public void testAuthorizeReturnDeniesOtherUser() {
        Pad owned = new Pad();
        owned.setUser(new User());

        when(userService.getAuthenticatedUser()).thenReturn(new User());

        aspect.authorizeReturn(owned);
    }

    /**
     * Tests authorizeReturn() permits access to the owner.
     */
    @Test
    public void testAuthorizeReturnPermitsOwner() {
        User owner = new User();

        Pad owned = new Pad();
        owned.setUser(owner);

        when(userService.getAuthenticatedUser()).thenReturn(owner);

        aspect.authorizeReturn(owned);
    }

}
