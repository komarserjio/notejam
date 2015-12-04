package net.notejam.spring.note;

import static org.junit.Assert.assertEquals;
import static org.junit.Assert.assertFalse;

import org.junit.Before;
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
@WithMockUser(NoteServiceTest.USER_EMAIL)
public class NoteServiceTest {

    @Autowired
    private UserService userService;

    @Autowired
    private PadService padService;

    @Autowired
    private NoteService service;
    
    /**
     * The given authenticated user.
     */
    final static String USER_EMAIL = "test@example.org";

    /**
     * Given the authenticated user {@link #USER_EMAIL} exists.
     */
    @Before
    public void signupAuthenticatedUser() {
        userService.signUp(USER_EMAIL, "password");
    }

    /**
     * Tests saveNote() without pad.
     */
    @Test
    public void testSaveNoteWithoutPad() {
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
    public void testSaveNoteWithPad() {
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
    public void testDeleteNote() {
        Note note = service.buildNote(null);
        note.setName("name");
        note.setText("text");

        service.saveNote(note, null);

        service.deleteNote(note);
        assertFalse(service.getNote(note.getId()).isPresent());
    }

}
