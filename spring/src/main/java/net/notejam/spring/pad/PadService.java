package net.notejam.spring.pad;

import java.time.Instant;
import java.util.List;
import java.util.Optional;

import javax.transaction.Transactional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import net.notejam.spring.note.NoteService;
import net.notejam.spring.security.owner.PermitOwner;
import net.notejam.spring.user.User;
import net.notejam.spring.user.UserService;

/**
 * The pad service.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Service
public class PadService {

    /**
     * The pad repository.
     */
    @Autowired
    private PadRepository padRepository;

    /**
     * The user service.
     */
    @Autowired
    private UserService userService;

    /**
     * The note service.
     */
    @Autowired
    private NoteService noteService;

    /**
     * Returns all pads for the currently authenticated user.
     *
     * @return The user's pads
     */
    @Transactional
    public List<Pad> getAllPads() {
        User user = userService.getAuthenticatedUser();
        return padRepository.findByUser(user);
    }

    /**
     * Loads a pad from the storage.
     *
     * @param id
     *            The pad id
     * @return The pad
     */
    @PermitOwner
    public Optional<Pad> getPad(final int id) {
        return Optional.ofNullable(padRepository.findOne(id));
    }

    /**
     * Deletes a pad and its notes.
     *
     * @param pad
     *            The pad
     */
    @Transactional
    public void deletePad(@PermitOwner final Pad pad) {
        noteService.deleteNotes(pad);
        padRepository.delete(pad);
    }

    /**
     * Builds a new pad with an empty name.
     *
     * The pad is not save yet. Use {@link #savePad(Pad)} to save it.
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
     * Safes a pad.
     *
     * The pad should be created with {@link #buildPad()}.
     *
     * @param pad
     *            The unsaved pad.
     */
    @Transactional
    public void savePad(@PermitOwner final Pad pad) {
        padRepository.save(pad);
    }

}
