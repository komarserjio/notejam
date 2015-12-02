package net.notejam.spring.security.owner;

import java.util.Optional;

import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.AccessDeniedException;
import org.springframework.security.test.context.support.WithMockUser;
import org.springframework.test.context.junit4.SpringJUnit4ClassRunner;

import net.notejam.spring.pad.Pad;
import net.notejam.spring.test.IntegrationTest;
import net.notejam.spring.user.User;
import net.notejam.spring.user.UserService;

/**
 * An integration test for the {@link PermitOwner}.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@IntegrationTest
@RunWith(SpringJUnit4ClassRunner.class)
public class PermitOwnerIntegrationTest {

    @Autowired
    private UserService userService;

    /**
     * Tests returning an owned object.
     */
    @Test
    @WithMockUser("testPermitReturnOwned@example.net")
    public void testPermitReturnOwned() {
        userService.signUp("testPermitReturnOwned@example.net", "password");
        User user = userService.getAuthenticatedUser();

        Pad pad = new Pad();
        pad.setUser(user);

        returnOwned(pad);
    }

    /**
     * Tests returning an owned object.
     */
    @Test
    @WithMockUser("testPermitReturnOwnedOptional@example.net")
    public void testPermitReturnOwnedOptional() {
        userService.signUp("testPermitReturnOwnedOptional@example.net", "password");
        User user = userService.getAuthenticatedUser();

        Pad pad = new Pad();
        pad.setUser(user);

        returnOwned(Optional.of(pad));
    }

    /**
     * Tests returning an owned object with no owner.
     */
    @Test
    @WithMockUser("testPermitReturnNull@example.net")
    public void testPermitReturnNull() {
        userService.signUp("testPermitReturnNull@example.net", "password");
        returnOwned(null);
    }

    /**
     * Tests returning an owned object with no owner.
     */
    @Test
    @WithMockUser("testPermitReturnEmptyOptional@example.net")
    public void testPermitReturnEmptyOptional() {
        userService.signUp("testPermitReturnEmptyOptional@example.net", "password");
        returnOwned(Optional.ofNullable((Owned) null));
    }

    /**
     * Tests returning an not owned object.
     */
    @Test(expected = AccessDeniedException.class)
    @WithMockUser("testPermitReturnNotOwned@example.net")
    public void testPermitReturnNotOwned() {
        userService.signUp("testPermitReturnNotOwned@example.net", "password");

        Pad pad = new Pad();
        pad.setUser(new User());

        returnOwned(pad);
    }

    /**
     * Tests returning an not owned object.
     */
    @Test(expected = AccessDeniedException.class)
    @WithMockUser("testPermitReturnOptionalNotOwned@example.net")
    public void testPermitReturnOptionalNotOwned() {
        userService.signUp("testPermitReturnOptionalNotOwned@example.net", "password");

        Pad pad = new Pad();
        pad.setUser(new User());

        returnOwned(Optional.of(pad));
    }

    /**
     * Returns an owned object.
     * 
     * @param user
     *            The owner.
     * @return The owned object.
     */
    @PermitOwner
    private <T> T returnOwned(T owned) {
        return owned;
    }

}
