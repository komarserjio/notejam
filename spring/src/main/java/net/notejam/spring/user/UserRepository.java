package net.notejam.spring.user;

import java.util.Optional;

import org.springframework.data.jpa.repository.JpaRepository;

public interface UserRepository extends JpaRepository<User, Integer> {
	
	/**
	 * Finds one user by its email address.
	 * 
	 * @param email The email.
	 * @return The user or null
	 */
	public Optional<User> findOneByEmail(String email);
	
}