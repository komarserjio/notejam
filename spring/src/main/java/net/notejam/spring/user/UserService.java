package net.notejam.spring.user;

import javax.transaction.Transactional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

/**
 * The user service
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Service
public class UserService {

	@Autowired
	private UserRepository repository;
	
	/**
	 * Checks if an email is already registered.
	 * 
	 * @param email The email.
	 * @return True, if the email is already registered.
	 */
	public boolean isEmailRegistered(String email) {
		return repository.findByEmail(email) != null;
	}
	
	/**
	 * Signs up a new user
	 * 
	 * @param signupUser The new user
	 */
	@Transactional
	public void signUp(SignupUser signupUser) {
		User user = new User();
		user.setEmail(signupUser.getEmail());
		
		repository.save(user);
	}
	
}
