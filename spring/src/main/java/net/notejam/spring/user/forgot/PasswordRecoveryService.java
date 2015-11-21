package net.notejam.spring.user.forgot;

import java.math.BigInteger;
import java.security.SecureRandom;
import java.time.Instant;
import java.time.Period;
import java.util.Optional;
import java.util.Random;

import javax.transaction.Transactional;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.scheduling.annotation.Async;
import org.springframework.scheduling.annotation.Scheduled;
import org.springframework.stereotype.Service;

import net.notejam.spring.user.User;
import net.notejam.spring.user.UserRepository;

/**
 * Service providing an API for password recovery.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Service
public class PasswordRecoveryService {

    @Autowired
    private RecoveryTokenRepository tokenRepository;

    @Autowired
    private UserRepository userRepository;

    @Value("${recovery.lifetime}")
    private Period tokenLifetime;

    private Random random = new SecureRandom();

    private static Logger logger = LoggerFactory.getLogger(PasswordRecoveryService.class);

    /**
     * Starts the password recovery process.
     * 
     * If the email doesn't belong to a user the process stops silently.
     * 
     * @param email
     *            The email
     */
    @Async
    @Transactional
    public void startRecoveryProcess(String email) {
        Optional<User> user = userRepository.findOneByEmail(email);

        if (!user.isPresent()) {
            logger.info("Cancel password recovery for non existing user {}", email);
            return;
        }

        RecoveryToken token = new RecoveryToken();
        token.setUser(user.get());
        token.setToken(generateToken());
        token.setExpiration(determineExpiration());
        tokenRepository.save(token);
    }

    /**
     * Deletes expired tokens from the storage.
     */
    @Transactional
    @Scheduled(cron = "59 59 3 * * *")
    public void purgeExpired() {
        logger.info("Purge expired recovery tokens");
        tokenRepository.deleteByExpirationLessThan(Instant.now());
    }

    /**
     * Determines the time when a new token will expire.
     * 
     * @return The expiration time of a new token
     */
    private Instant determineExpiration() {
        return Instant.now().plus(tokenLifetime);
    }

    /**
     * Generates a secure random string.
     * 
     * @return A random string
     * @see <a href=
     *      "http://stackoverflow.com/questions/41107/how-to-generate-a-random-alpha-numeric-string">
     *      How to generate a random alpha-numeric string?</a>
     */
    private String generateToken() {
        return new BigInteger(130, random).toString(32);
    }

}
