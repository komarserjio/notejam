package net.notejam.spring.note;

import java.time.Instant;
import java.util.Optional;

import javax.transaction.Transactional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
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
     * Loads a note from the storage.
     * 
     * @param id
     *            The note id
     * @return The note
     */
    @PermitOwner
    public Optional<Note> getNote(int id) {
        return Optional.ofNullable(repository.findOne(id));
    }

    /**
     * Pages through all notes of a pad.
     * 
     * @param pad
     *            The pad
     * @param pageable
     *            The paging parameters
     * @return The notes
     */
    @Transactional
    public Page<Note> getPadNotes(@PermitOwner Pad pad, Pageable pageable) {
        return repository.findByPad(pad, pageable);
    }

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
    public void saveNote(@PermitOwner Note note, @PermitOwner Pad pad) {
        note.setPad(pad);
        repository.save(note);
    }

    /**
     * Deletes a note.
     * 
     * @param note
     *            The note
     */
    @Transactional
    public void deleteNote(@PermitOwner Note note) {
        repository.delete(note);
    }

}
