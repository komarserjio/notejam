package net.notejam.spring.pad;

import org.springframework.data.jpa.repository.JpaRepository;

/**
 * The pad repository.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
public interface PadRepository extends JpaRepository<Pad, Integer> {

}
