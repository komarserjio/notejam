package net.notejam.spring.pad;

import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;

import net.notejam.spring.user.User;

/**
 * The pad repository.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
interface PadRepository extends JpaRepository<Pad, Integer> {

    /**
     * Returns all pads for a user.
     *
     * @param user
     *            The user
     * @return The user's pads
     */
    List<Pad> findByUser(User user);

}
