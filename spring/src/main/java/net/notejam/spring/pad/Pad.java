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
@Table(indexes = @Index(columnList = "created") )
public class Pad extends AbstractPersistable<Integer>implements Owned {

    private static final long serialVersionUID = -1186217744141902841L;

    @NotNull
    private Instant created;

    @Size(max = 100)
    @NotEmpty
    private String name;

    @ManyToOne
    @NotNull
    private User user;

    public Instant getCreated() {
        return created;
    }

    public void setCreated(Instant created) {
        this.created = created;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public void setUser(User user) {
        this.user = user;
    }

    @Override
    public User getUser() {
        return user;
    }

}
