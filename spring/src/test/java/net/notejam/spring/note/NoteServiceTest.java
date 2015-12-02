package net.notejam.spring.note;

import static org.junit.Assert.assertEquals;
import static org.junit.Assert.assertFalse;

import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.test.context.support.WithMockUser;
import org.springframework.test.context.junit4.SpringJUnit4ClassRunner;

import net.notejam.spring.pad.Pad;
import net.notejam.spring.pad.PadService;
import net.notejam.spring.test.IntegrationTest;
import net.notejam.spring.user.UserService;

/**
 * An integration test for the {@link NoteService}.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@IntegrationTest
@RunWith(SpringJUnit4ClassRunner.class)
public class NoteServiceTest {

    @Autowired
    private UserService userService;

    @Autowired
    private PadService padService;

    @Autowired
    private NoteService service;

    /**
     * Tests saveNote() without pad.
     */
    @Test
    @WithMockUser("testSaveNote@example.net")
    public void testSaveNoteWithoutPad() {
        userService.signUp("testSaveNote@example.net", "password");

        Note note = service.buildNote(null);
        note.setName("name");
        note.setText("text");

        service.saveNote(note, null);

        assertEquals(note, service.getNote(note.getId()).get());
    }

    /**
     * Tests saveNote() with pad.
     */
    @Test
    @WithMockUser("testSaveNote2@example.net")
    public void testSaveNoteWithPad() {
        userService.signUp("testSaveNote2@example.net", "password");

        Pad pad = padService.buildPad();
        pad.setName("test");
        padService.savePad(pad);

        Note note = service.buildNote(pad.getId());
        note.setName("name");
        note.setText("text");

        service.saveNote(note, pad);

        assertEquals(note, service.getNote(note.getId()).get());
    }

    /**
     * Tests deleteNote().
     */
    @Test
    @WithMockUser("deleteNote@example.net")
    public void testDeleteNote() {
        userService.signUp("deleteNote@example.net", "password");

        Note note = service.buildNote(null);
        note.setName("name");
        note.setText("text");

        service.saveNote(note, null);

        service.deleteNote(note);
        assertFalse(service.getNote(note.getId()).isPresent());
    }

}
