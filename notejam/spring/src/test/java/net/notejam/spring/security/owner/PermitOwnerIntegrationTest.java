package net.notejam.spring.security.owner;

import java.util.Optional;

import org.junit.Ignore;
import org.junit.Rule;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.access.AccessDeniedException;
import org.springframework.security.test.context.support.WithMockUser;
import org.springframework.test.context.junit4.SpringJUnit4ClassRunner;

import net.notejam.spring.pad.Pad;
import net.notejam.spring.test.IntegrationTest;
import net.notejam.spring.user.SignedUpUserProvider;
import net.notejam.spring.user.User;

/**
 * An integration test for the {@link PermitOwner}.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@IntegrationTest
@RunWith(SpringJUnit4ClassRunner.class)
@WithMockUser(SignedUpUserProvider.EMAIL)
public class PermitOwnerIntegrationTest {

    @Rule
    @Autowired
    public SignedUpUserProvider userProvider;

    /**
     * Returning an owned object should be permitted.
     */
    @Test
    public void testPermitReturnOwned() {
        Pad pad = new Pad();
        pad.setUser(userProvider.getUser());

        returnOwned(pad);
    }

    /**
     * Sending an owned object is permitted for the owner.
     */
    @Test
    public void testPermitSendOwned() {
        Pad pad = new Pad();
        pad.setUser(userProvider.getUser());

        sendOwned(pad);
    }

    /**
     * Returning an owned Optional should be permitted.
     */
    @Test
    public void testPermitReturnOwnedOptional() {
        Pad pad = new Pad();
        pad.setUser(userProvider.getUser());

        returnOwned(Optional.of(pad));
    }

    /**
     * Sending an owned Optional should be permitted.
     */
    @Test
    @Ignore
    public void testPermitSendOwnedOptional() {
        Pad pad = new Pad();
        pad.setUser(userProvider.getUser());

        sendOwned(Optional.of(pad));
    }

    /**
     * Returning null should be permitted.
     */
    @Test
    public void testPermitReturnNull() {
        returnOwned(null);
    }

    /**
     * Sending null should be permitted.
     */
    @Test
    public void testPermitSendNull() {
        sendOwned(null);
    }

    /**
     * Returning an empty Optional should be permitted.
     */
    @Test
    public void testPermitReturnEmptyOptional() {
        returnOwned(Optional.ofNullable((Owned) null));
    }

    /**
     * Sending an empty Optional should be permitted.
     */
    @Test
    @Ignore
    public void testPermitSendEmptyOptional() {
        sendOwned(Optional.ofNullable((Owned) null));
    }

    /**
     * Returning an not owned object should be denied.
     */
    @Test(expected = AccessDeniedException.class)
    public void testPermitReturnNotOwned() {
        Pad pad = new Pad();
        pad.setUser(new User());

        returnOwned(pad);
    }

    /**
     * Sending an not owned object should be denied.
     */
    @Test(expected = AccessDeniedException.class)
    public void testPermitSendNotOwned() {
        Pad pad = new Pad();
        pad.setUser(new User());

        sendOwned(pad);
    }

    /**
     * Returning an not owned object should be denied.
     */
    @Test(expected = AccessDeniedException.class)
    public void testPermitReturnOptionalNotOwned() {
        Pad pad = new Pad();
        pad.setUser(new User());

        returnOwned(Optional.of(pad));
    }

    /**
     * Sending an not owned object should be denied.
     */
    @Test(expected = AccessDeniedException.class)
    @Ignore
    public void testPermitSendOptionalNotOwned() {
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
