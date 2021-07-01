package net.notejam.spring.user.forgot;

import java.time.Instant;
import java.util.Optional;

import org.springframework.data.jpa.repository.JpaRepository;

/**
 * The token repository.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
public interface RecoveryTokenRepository extends JpaRepository<RecoveryToken, Integer> {

    /**
     * Deletes all tokens which are expired.
     *
     * @param date
     *            The time
     */
    void deleteByExpirationLessThan(Instant date);

    /**
     * Find a non expired token which matches the id and token.
     *
     * @param id
     *            The token id
     * @param token
     *            The token string
     * @param time
     *            The current time
     * @return The token
     */
    Optional<RecoveryToken> findOneByIdAndTokenAndExpirationGreaterThan(int id, String token, Instant time);

}
