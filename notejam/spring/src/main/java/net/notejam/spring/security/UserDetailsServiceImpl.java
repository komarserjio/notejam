package net.notejam.spring.security;

import java.util.ArrayList;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.userdetails.User;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.stereotype.Service;

import net.notejam.spring.user.UserRepository;

/**
 * UserDetailsService Implementation
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Service
public class UserDetailsServiceImpl implements UserDetailsService {

    /**
     * The user repository.
     */
    @Autowired
    private UserRepository repository;

    @Override
    public UserDetails loadUserByUsername(final String username) {
        String password = repository.findOneByEmail(username)
                .orElseThrow(() -> new UsernameNotFoundException(String.format("%s not found", username)))
                .getPassword();
        return new User(username, password, new ArrayList<>());
    }

}
