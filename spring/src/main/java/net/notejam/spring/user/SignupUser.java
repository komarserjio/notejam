package net.notejam.spring.user;

import javax.validation.constraints.NotNull;
import javax.validation.constraints.Size;

import org.hibernate.validator.constraints.NotEmpty;

import de.malkusch.validation.constraints.EqualProperties;

/**
 * User for sign up process.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@EqualProperties(value = {"repeatedPassword", "password"}, violationOnPropery = true)
public class SignupUser extends User {
	
	private static final long serialVersionUID = -5862649928696271525L;

	@NotNull
	private String repeatedPassword;
	
	@Size(min=8, max=128)
	@NotEmpty
	private String password;
	
	public String getPassword() {
		return password;
	}

	public void setPassword(String password) {
		this.password = password;
	}

	public String getRepeatedPassword() {
		return repeatedPassword;
	}

	public void setRepeatedPassword(String repeatedPassword) {
		this.repeatedPassword = repeatedPassword;
	}

}
