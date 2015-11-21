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

    @NotNull
    @ManyToOne
    private User user;

    @NotNull
    private String token;

    @NotNull
    @Future
    private Instant expiration;

    public Instant getExpiration() {
        return expiration;
    }

    public void setExpiration(Instant expiration) {
        this.expiration = expiration;
    }

    public User getUser() {
        return user;
    }

    public void setUser(User user) {
        this.user = user;
    }

    public String getToken() {
        return token;
    }

    public void setToken(String token) {
        this.token = token;
    }

}
