package net.notejam.spring.pad;

import java.time.Instant;

import javax.transaction.Transactional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import net.notejam.spring.user.User;
import net.notejam.spring.user.UserRepository;
import net.notejam.spring.user.UserService;

/**
 * The pad service
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Service
public class PadService {

    @Autowired
    private UserRepository userRepository;

    @Autowired
    private PadRepository padRepository;

    @Autowired
    private UserService userService;

    /**
     * Creates a new pad.
     * 
     * @param name
     *            The pad name.
     */
    @Transactional
    public Pad createPad(String name) {
        Pad pad = new Pad();
        pad.setName(name);
        pad.setCreated(Instant.now());
        padRepository.save(pad);

        User user = userService.getAuthenticatedUser();
        user.getPads().add(pad);
        userRepository.save(user);

        return pad;
    }
}
