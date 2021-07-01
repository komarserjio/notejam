package net.notejam.spring.note;

import java.time.Instant;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.Index;
import javax.persistence.Lob;
import javax.persistence.ManyToOne;
import javax.persistence.Table;
import javax.validation.constraints.NotNull;
import javax.validation.constraints.Size;

import org.hibernate.validator.constraints.NotEmpty;
import org.springframework.data.jpa.domain.AbstractPersistable;

import net.notejam.spring.pad.Pad;
import net.notejam.spring.security.owner.Owned;
import net.notejam.spring.user.User;

/**
 * The note.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Entity
@Table(indexes = { @Index(columnList = "updated"), @Index(columnList = "name") })
public class Note extends AbstractPersistable<Integer>implements Owned {

    private static final long serialVersionUID = -1445367127777923455L;

    /**
     * The last update time.
     */
    @NotNull
    private Instant updated;

    /**
     * The owner.
     */
    @ManyToOne
    @NotNull
    private User user;

    /**
     * The pad.
     */
    @ManyToOne
    private Pad pad;

    /**
     * The name.
     */
    @NotEmpty
    @Size(max = 100)
    private String name;

    /**
     * The text.
     */
    @NotEmpty
    @Lob
    @Column(length = 10000)
    private String text;

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
     * Returns the text.
     *
     * @return The text
     */
    public String getText() {
        return text;
    }

    /**
     * Sets the text.
     *
     * @param text The text.
     */
    public void setText(final String text) {
        this.text = text;
    }

    /**
     * Returns the pad.
     *
     * @return The pad or null.
     */
    public Pad getPad() {
        return pad;
    }

    /**
     * Sets the pad.
     *
     * @param pad The pad or null.
     */
    public void setPad(final Pad pad) {
        this.pad = pad;
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

    /**
     * Returns the last update time.
     *
     * @return The time.
     */
    public Instant getUpdated() {
        return updated;
    }

    /**
     * Sets the last update time.
     *
     * @param updated The time.
     */
    public void setUpdated(final Instant updated) {
        this.updated = updated;
    }

}
