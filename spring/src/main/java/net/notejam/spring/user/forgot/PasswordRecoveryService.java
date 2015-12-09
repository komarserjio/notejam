package net.notejam.spring.user.forgot;

import java.math.BigInteger;
import java.time.Instant;
import java.time.Period;
import java.util.HashMap;
import java.util.Locale;
import java.util.Map;
import java.util.Optional;
import java.util.Random;

import javax.transaction.Transactional;

import org.apache.commons.lang3.RandomStringUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.context.MessageSource;
import org.springframework.mail.SimpleMailMessage;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.scheduling.annotation.Async;
import org.springframework.scheduling.annotation.Scheduled;
import org.springframework.stereotype.Service;
import org.springframework.web.util.UriComponentsBuilder;

import net.notejam.spring.URITemplates;
import net.notejam.spring.user.User;
import net.notejam.spring.user.UserRepository;
import net.notejam.spring.user.UserService;

/**
 * Service providing an API for password recovery.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Service
public class PasswordRecoveryService {

    /**
     * The token repository.
     */
    @Autowired
    private RecoveryTokenRepository tokenRepository;

    /**
     * The user repository.
     */
    @Autowired
    private UserRepository userRepository;

    /**
     * The user service.
     */
    @Autowired
    private UserService userService;

    /**
     * The token life time.
     */
    @Value("${recovery.lifetime}")
    private Period tokenLifetime;

    /**
     * The length of the generated password.
     */
    @Value("${recovery.length}")
    private int passwordLength;

    /**
     * A random instance.
     */
    @Autowired
    private Random random;

    /**
     * The mail sender.
     */
    @Autowired(required = false)
    private JavaMailSender mailSender;

    /**
     * The sender's email address.
     */
    @Value("${email.sender}")
    private String sender;

    /**
     * The message source.
     */
    @Autowired
    private MessageSource messageSource;

    /**
     * The logger.
     */
    private static final Logger LOGGER = LoggerFactory.getLogger(PasswordRecoveryService.class);

    /**
     * Recovers the password in exchange for a valid token.
     *
     * @param id
     *            The token id
     * @param token
     *            The token string
     * @return The new password
     * @throws InvalidTokenException
     *             The token was not valid
     */
    @Transactional
    public String recoverPassword(final int id, final String token) throws InvalidTokenException {
        RecoveryToken recoveryToken = tokenRepository
                .findOneByIdAndTokenAndExpirationGreaterThan(id, token, Instant.now())
                .orElseThrow(() -> new InvalidTokenException());

        String password = generatePassword();
        userService.changePassword(recoveryToken.getUser(), password);
        tokenRepository.delete(recoveryToken);
        return password;
    }

    /**
     * Generates a random password.
     *
     * @return The generated password
     */
    private String generatePassword() {
        return RandomStringUtils.randomAlphanumeric(passwordLength);
    }

    /**
     * Starts the password recovery process.
     *
     * If the email doesn't belong to a user the process stops silently.
     *
     * @param email
     *            The email
     * @param uriBuilder
     *            A prepared uri builder with the fully qualified host name.
     * @param locale
     *            The locale in which the process should happen
     */
    @Async("mailExecutor")
    @Transactional
    public void startRecoveryProcess(final String email, final UriComponentsBuilder uriBuilder, final Locale locale) {
        Optional<User> user = userRepository.findOneByEmail(email);

        if (!user.isPresent()) {
            LOGGER.info("Cancel password recovery for non existing user {}", email);
            return;
        }

        RecoveryToken token = new RecoveryToken();
        token.setUser(user.get());
        token.setToken(generateToken());
        token.setExpiration(determineExpiration());
        tokenRepository.save(token);

        sendRecoveryMail(token, uriBuilder, locale);
    }

    /**
     * Sends the recovery mail.
     *
     * @param token
     *            The recovery token
     * @param uriBuilder
     *            A prepared uri builder with the fully qualified host name.
     * @param locale
     *            The process locale
     */
    private void sendRecoveryMail(final RecoveryToken token, final UriComponentsBuilder uriBuilder,
            final Locale locale) {
        if (mailSender == null) {
            LOGGER.warn("Mail transport is not available. Consider setting spring.mail.host in application.properties");
            return;
        }

        SimpleMailMessage message = new SimpleMailMessage();
        message.setFrom(sender);
        message.setSubject(messageSource.getMessage("forgot.mail.subject", null, locale));
        message.setTo(token.getUser().getEmail());

        String uri = buildRecoveryURI(token, uriBuilder);
        message.setText(messageSource.getMessage("forgot.mail.message", new String[] { uri }, locale));

        mailSender.send(message);
    }

    /**
     * Builds the fully qualified URI for recovering the password.
     *
     * @param token
     *            The recovery token
     * @param uriBuilder
     *            A prepared uri builder with the fully qualified host name.
     * @return The URI to recover the password
     */
    private static String buildRecoveryURI(final RecoveryToken token, final UriComponentsBuilder uriBuilder) {
        Map<String, String> uriVariables = new HashMap<>();
        uriVariables.put("id", token.getId().toString());
        uriVariables.put("token", token.getToken());

        return uriBuilder.replacePath(URITemplates.RECOVER_PASSWORD).buildAndExpand(uriVariables).toUriString();
    }

    /**
     * Deletes expired tokens from the storage.
     */
    @Transactional
    @Scheduled(cron = "59 59 3 * * *")
    public void purgeExpired() {
        LOGGER.info("Purge expired recovery tokens");
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
