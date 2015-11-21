package net.notejam.spring.user.forgot;

import java.time.Instant;

import org.springframework.data.jpa.repository.JpaRepository;

/**
 * The token repository
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
public interface RecoveryTokenRepository extends JpaRepository<RecoveryToken, Integer> {

    public void deleteByExpirationLessThan(Instant date);

}