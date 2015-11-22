package net.notejam.spring.pad;

import java.time.Instant;

import javax.transaction.Transactional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import net.notejam.spring.security.owner.PermitOwner;
import net.notejam.spring.user.User;
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
    private PadRepository padRepository;

    @Autowired
    private UserService userService;

    /**
     * Loads a pad from the storage.
     * 
     * @param id
     *            The pad id
     * @return The pad
     */
    @PermitOwner
    public Pad getPad(int id) {
        return padRepository.findOne(id);
    }

    /**
     * Deletes a pad.
     * 
     * @param pad
     *            The pad
     */
    @Transactional
    public void deletePad(@PermitOwner Pad pad) {
        User user = pad.getUser();
        user.getPads().remove(pad);
        padRepository.delete(pad);
    }

    /**
     * Builds a new pad with an empty name.
     * 
     * The pad is not save yet. Use {@link #createPad(String)} to save it.
     * 
     * @return The new pad
     */
    public Pad buildPad() {
        Pad pad = new Pad();
        pad.setCreated(Instant.now());
        pad.setUser(userService.getAuthenticatedUser());
        return pad;
    }

    /**
     * Saves an edited pad.
     * 
     * @param pad
     *            The edited pad
     */
    @Transactional
    public void editPad(@PermitOwner Pad pad) {
        padRepository.save(pad);
    }

    /**
     * Safes a new pad.
     * 
     * The pad should be created with {@link #buildPad()}.
     * 
     * @param pad
     *            The unsaved pad.
     */
    @Transactional
    public void createPad(Pad pad) {
        User user = userService.getAuthenticatedUser();
        user.getPads().add(pad);
        padRepository.save(pad);
    }

}
