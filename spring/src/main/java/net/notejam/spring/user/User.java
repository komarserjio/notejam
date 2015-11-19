package net.notejam.spring.user;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.validation.constraints.Size;

import org.hibernate.validator.constraints.Email;
import org.hibernate.validator.constraints.NotEmpty;
import org.springframework.data.jpa.domain.AbstractPersistable;

import net.notejam.spring.user.validator.UniqueEmail;
import net.notejam.spring.user.validator.UniqueEmail.UserInput;

/**
 * The user
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Entity
public class User extends AbstractPersistable<Integer> {

	private static final long serialVersionUID = -7874055769861590146L;

	@NotEmpty
	@Email
	@UniqueEmail(groups=UserInput.class)
	@Size(max=75)
	@Column(unique=true)
	private String email;
	
	public String getEmail() {
		return email;
	}

	public void setEmail(String email) {
		this.email = email;
	}

}
