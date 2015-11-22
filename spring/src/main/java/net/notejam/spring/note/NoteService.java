package net.notejam.spring.note;

import java.time.Instant;

import javax.transaction.Transactional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import net.notejam.spring.pad.Pad;
import net.notejam.spring.security.owner.PermitOwner;
import net.notejam.spring.user.UserService;

/**
 * The note service.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Service
public class NoteService {

    @Autowired
    private NoteRepository repository;

    @Autowired
    private UserService userService;

    /**
     * Builds a new empty note.
     * 
     * The note is not save yet. Use {@link #createNote(Note)} to save it.
     * 
     * @return The new note
     */
    public Note buildNote() {
        Note note = new Note();
        note.setUpdated(Instant.now());
        note.setUser(userService.getAuthenticatedUser());
        return note;
    }

    /**
     * Saves a new new note.
     * 
     * @param note
     *            The new note
     * @param pad
     *            The optional pad to which this note will belong, or null
     */
    @Transactional
    public void createNote(Note note, @PermitOwner Pad pad) {
        note.setPad(pad);
        repository.save(note);
    }

}
