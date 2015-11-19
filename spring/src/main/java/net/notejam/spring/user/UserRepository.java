package net.notejam.spring.user;

import org.springframework.data.jpa.repository.JpaRepository;

public interface UserRepository extends JpaRepository<User, Integer> {
	
	/**
	 * Finds one user by its email address.
	 * 
	 * @param email The email.
	 * @return The user or null
	 */
	public User findByEmail(String email);
	
}