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
@Table(indexes = @Index(columnList = "updated") )
public class Note extends AbstractPersistable<Integer>implements Owned {

    private static final long serialVersionUID = -1445367127777923455L;

    @NotNull
    private Instant updated;

    @ManyToOne
    @NotNull
    private User user;

    @ManyToOne
    private Pad pad;

    @NotEmpty
    @Size(max = 100)
    private String name;

    @NotEmpty
    @Lob
    @Column(length = 10000)
    private String text;

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getText() {
        return text;
    }

    public void setText(String text) {
        this.text = text;
    }

    public Pad getPad() {
        return pad;
    }

    public void setPad(Pad pad) {
        this.pad = pad;
    }

    public void setUser(User user) {
        this.user = user;
    }

    @Override
    public User getUser() {
        return user;
    }

    public Instant getUpdated() {
        return updated;
    }

    public void setUpdated(Instant updated) {
        this.updated = updated;
    }

}
