package net.notejam.spring.note;

import java.time.Instant;
import java.util.Optional;

import javax.transaction.Transactional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;

import net.notejam.spring.pad.Pad;
import net.notejam.spring.pad.PadService;
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

    /**
     * The note repository.
     */
    @Autowired
    private NoteRepository repository;

    /**
     * The pad service.
     */
    @Autowired
    private PadService padService;

    /**
     * The user service.
     */
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
    public Optional<Note> getNote(final int id) {
        return Optional.ofNullable(repository.findOne(id));
    }

    /**
     * Pages through all notes.
     *
     * @param pageable
     *            The paging parameters
     * @return The notes
     */
    @Transactional
    public Page<Note> getNotes(final Pageable pageable) {
        return repository.findByUser(userService.getAuthenticatedUser(), pageable);
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
    public Page<Note> getPadNotes(@PermitOwner final Pad pad, final Pageable pageable) {
        return repository.findByPad(pad, pageable);
    }

    /**
     * Builds a new empty note.
     *
     * The note is not save yet. Use {@link #createNote(Note)} to save it.
     *
     * @param padId
     *            The preselected pad.
     *
     * @return The new note
     */
    public Note buildNote(final Integer padId) {
        Note note = new Note();
        note.setUpdated(Instant.now());
        note.setUser(userService.getAuthenticatedUser());

        if (padId != null) {
            note.setPad(padService.getPad(padId).get());
        }

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
    public void saveNote(@PermitOwner final Note note, @PermitOwner final Pad pad) {
        note.setPad(pad);
        note.setUpdated(Instant.now());
        repository.save(note);
    }

    /**
     * Deletes a note.
     *
     * @param note
     *            The note
     */
    @Transactional
    public void deleteNote(@PermitOwner final Note note) {
        repository.delete(note);
    }

    /**
     * Deletes all notes of a pad.
     *
     * @param pad
     *            The pad
     */
    @Transactional
    public void deleteNotes(@PermitOwner final Pad pad) {
        repository.deleteByPad(pad);
    }

}
