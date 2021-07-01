package net.notejam.spring.pad;

import java.time.Instant;

import javax.persistence.Entity;
import javax.persistence.Index;
import javax.persistence.ManyToOne;
import javax.persistence.Table;
import javax.validation.constraints.NotNull;
import javax.validation.constraints.Size;

import org.hibernate.validator.constraints.NotEmpty;
import org.springframework.data.jpa.domain.AbstractPersistable;

import net.notejam.spring.security.owner.Owned;
import net.notejam.spring.user.User;

/**
 * The pad groups notes.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Entity
@Table(indexes = @Index(columnList = "created"))
public class Pad extends AbstractPersistable<Integer>implements Owned {

    private static final long serialVersionUID = -1186217744141902841L;

    /**
     * The time of creation.
     */
    @NotNull
    private Instant created;

    /**
     * The name.
     */
    @Size(max = 100)
    @NotEmpty
    private String name;

    /**
     * The owner.
     */
    @ManyToOne
    @NotNull
    private User user;

    /**
     * Returns time of creation.
     *
     * @return time of creation.
     */
    public Instant getCreated() {
        return created;
    }

    /**
     * Sets the time of creation.
     *
     * @param created The time of creation.
     */
    public void setCreated(final Instant created) {
        this.created = created;
    }

    /**
     * Returns the name.
     *
     * @return The name.
     */
    public String getName() {
        return name;
    }

    /**
     * Sets the name.
     *
     * @param name The name.
     */
    public void setName(final String name) {
        this.name = name;
    }

    /**
     * Sets the owner.
     *
     * @param user The owner.
     */
    public void setUser(final User user) {
        this.user = user;
    }

    @Override
    public User getUser() {
        return user;
    }

}
