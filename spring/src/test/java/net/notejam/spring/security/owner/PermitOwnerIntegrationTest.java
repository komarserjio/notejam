package net.notejam.spring.security.owner;

import java.util.Optional;

import org.junit.Ignore;
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
     * Returning an owned object should be permitted.
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
     * Sending an owned object is permitted for the owner.
     */
    @Test
    @WithMockUser("testPermitSendOwned@example.net")
    public void testPermitSendOwned() {
        userService.signUp("testPermitSendOwned@example.net", "password");
        User user = userService.getAuthenticatedUser();

        Pad pad = new Pad();
        pad.setUser(user);

        sendOwned(pad);
    }

    /**
     * Returning an owned Optional should be permitted.
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
     * Sending an owned Optional should be permitted.
     */
    @Test
    @WithMockUser("testPermitSendOwnedOptional@example.net")
    @Ignore
    public void testPermitSendOwnedOptional() {
        userService.signUp("testPermitSendOwnedOptional@example.net", "password");
        User user = userService.getAuthenticatedUser();

        Pad pad = new Pad();
        pad.setUser(user);

        sendOwned(Optional.of(pad));
    }

    /**
     * Returning null should be permitted.
     */
    @Test
    @WithMockUser("testPermitReturnNull@example.net")
    public void testPermitReturnNull() {
        userService.signUp("testPermitReturnNull@example.net", "password");
        returnOwned(null);
    }

    /**
     * Sending null should be permitted.
     */
    @Test
    @WithMockUser("testPermitSendNull@example.net")
    public void testPermitSendNull() {
        userService.signUp("testPermitSendNull@example.net", "password");
        sendOwned(null);
    }

    /**
     * Returning an empty Optional should be permitted.
     */
    @Test
    @WithMockUser("testPermitReturnEmptyOptional@example.net")
    public void testPermitReturnEmptyOptional() {
        userService.signUp("testPermitReturnEmptyOptional@example.net", "password");
        returnOwned(Optional.ofNullable((Owned) null));
    }

    /**
     * Sending an empty Optional should be permitted.
     */
    @Test
    @WithMockUser("testPermitSendEmptyOptional@example.net")
    @Ignore
    public void testPermitSendEmptyOptional() {
        userService.signUp("testPermitSendEmptyOptional@example.net", "password");
        sendOwned(Optional.ofNullable((Owned) null));
    }

    /**
     * Returning an not owned object should be denied.
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
     * Sending an not owned object should be denied.
     */
    @Test(expected = AccessDeniedException.class)
    @WithMockUser("testPermitSendNotOwned@example.net")
    public void testPermitSendNotOwned() {
        userService.signUp("testPermitSendNotOwned@example.net", "password");

        Pad pad = new Pad();
        pad.setUser(new User());

        sendOwned(pad);
    }

    /**
     * Returning an not owned object should be denied.
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
     * Sending an not owned object should be denied.
     */
    @Test(expected = AccessDeniedException.class)
    @WithMockUser("testPermitSendOptionalNotOwned@example.net")
    @Ignore
    public void testPermitSendOptionalNotOwned() {
        userService.signUp("testPermitSendOptionalNotOwned@example.net", "password");

        Pad pad = new Pad();
        pad.setUser(new User());

        sendOwned(Optional.of(pad));
    }

    /**
     * Sends an owned object.
     * 
     * @param user
     *            The owned object.
     */
    private <T> void sendOwned(@PermitOwner T owned) {
    }

    /**
     * Returns an owned object.
     * 
     * @param user
     *            The owned object.
     * @return The owned object.
     */
    @PermitOwner
    private <T> T returnOwned(T owned) {
        return owned;
    }

}
