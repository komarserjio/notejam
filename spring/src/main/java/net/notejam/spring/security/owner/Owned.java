package net.notejam.spring.security.owner;

import net.notejam.spring.user.User;

/**
 * An entity which has a user as its owner.
 *
 * @author markus@malkusch.de
 *
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 * @see PermitOwner
 */
public interface Owned {

    /**
     * Returns the owner of this entity.
     *
     * @return The owner
     */
    User getUser();

}
