package net.notejam.spring.note;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.JpaRepository;

import net.notejam.spring.pad.Pad;
import net.notejam.spring.user.User;

/**
 * The note repository.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
interface NoteRepository extends JpaRepository<Note, Integer> {

    /**
     * Pages through all notes of a pad.
     *
     * @param pad
     *            The pad
     * @param pageable
     *            The paging parameters
     * @return The notes
     */
    Page<Note> findByPad(Pad pad, Pageable pageable);

    /**
     * Pages through all notes of a user.
     *
     * @param user
     *            The user
     * @param pageable
     *            The paging parameters
     * @return The notes
     */
    Page<Note> findByUser(User user, Pageable pageable);

    /**
     * Deletes all notes of a pad.
     *
     * @param pad
     *            The pad
     */
    void deleteByPad(Pad pad);

}
