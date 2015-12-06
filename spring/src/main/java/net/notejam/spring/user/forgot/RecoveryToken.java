package net.notejam.spring.user.forgot;

import java.time.Instant;

import javax.persistence.Entity;
import javax.persistence.ManyToOne;
import javax.validation.constraints.Future;
import javax.validation.constraints.NotNull;

import org.springframework.data.jpa.domain.AbstractPersistable;

import net.notejam.spring.user.User;

/**
 * The token to authorize a password recovery request.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Entity
public class RecoveryToken extends AbstractPersistable<Integer> {

    private static final long serialVersionUID = 5923083445165411558L;

    /**
     * The user.
     */
    @NotNull
    @ManyToOne
    private User user;

    /**
     * The token.
     */
    @NotNull
    private String token;

    /**
     * The expiration date.
     */
    @NotNull
    @Future
    private Instant expiration;

    /**
     * Returns the date when the token expires.
     *
     * @return The expiration date.
     */
    public Instant getExpiration() {
        return expiration;
    }

    /**
     * Sets the date when the token expires.
     *
     * @param expiration
     *            The expiration date.
     */
    public void setExpiration(final Instant expiration) {
        this.expiration = expiration;
    }

    /**
     * Returns the user.
     *
     * @return The user.
     */
    public User getUser() {
        return user;
    }

    /**
     * Sets the user.
     *
     * @param user
     *            The user.
     */
    public void setUser(final User user) {
        this.user = user;
    }

    /**
     * Returns the token.
     *
     * @return The token.
     */
    public String getToken() {
        return token;
    }

    /**
     * Sets the token.
     *
     * @param token
     *            The token.
     */
    public void setToken(final String token) {
        this.token = token;
    }

}
