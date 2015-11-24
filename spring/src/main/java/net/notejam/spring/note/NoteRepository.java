package net.notejam.spring.note;

import org.springframework.data.jpa.repository.JpaRepository;

import net.notejam.spring.pad.Pad;

/**
 * The note repository.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
public interface NoteRepository extends JpaRepository<Note, Integer> {

    /**
     * Deletes all notes of a pad.
     * 
     * @param pad The pad
     */
    public void deleteByPad(Pad pad);
    
}
