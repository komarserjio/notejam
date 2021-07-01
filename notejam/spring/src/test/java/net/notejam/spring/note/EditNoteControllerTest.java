package net.notejam.spring.note;

import static net.notejam.spring.test.UriUtil.buildUri;
import static net.notejam.spring.test.UriUtil.getPathVariable;
import static org.junit.Assert.assertEquals;
import static org.junit.Assert.assertNull;
import static org.springframework.security.test.web.servlet.request.SecurityMockMvcRequestPostProcessors.csrf;
import static org.springframework.security.test.web.servlet.request.SecurityMockMvcRequestPostProcessors.user;
import static org.springframework.test.web.servlet.request.MockMvcRequestBuilders.post;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.model;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.status;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.view;

import org.junit.Before;
import org.junit.Rule;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.test.context.support.WithMockUser;
import org.springframework.test.context.junit4.SpringJUnit4ClassRunner;
import org.springframework.test.web.servlet.MvcResult;

import net.notejam.spring.URITemplates;
import net.notejam.spring.note.controller.EditNoteController;
import net.notejam.spring.pad.Pad;
import net.notejam.spring.pad.PadService;
import net.notejam.spring.test.IntegrationTest;
import net.notejam.spring.test.MockMvcProvider;
import net.notejam.spring.user.SignedUpUserProvider;
import net.notejam.spring.user.UserService;

/**
 * An integration test for the {@link EditNoteController}.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@IntegrationTest
@RunWith(SpringJUnit4ClassRunner.class)
@WithMockUser(SignedUpUserProvider.EMAIL)
public class EditNoteControllerTest {

    @Autowired
    private PadService padService;
    
    @Autowired
    private UserService userService;
    
    @Autowired
    private NoteRepository repository;
    
    @Rule
    @Autowired
    public MockMvcProvider mockMvcProvider;
    
    @Rule
    @Autowired
    public SignedUpUserProvider userProvider;
    
    @Autowired
    private NoteService service;
    
    private Note note;
    
    /**
     * The provided note name.
     */
    private final String NAME = "name";
    
    /**
     * The edit note uri.
     */
    private String uri;
    
    private void setNote() {
        note = service.buildNote(null);
        note.setName(NAME);
        note.setText("text");
        service.saveNote(note, null);
    }
    
    @Before
    public void setUri() {
        setNote();
        
        uri = buildUri(URITemplates.EDIT_NOTE, note.getId());
    }

    /**
     * Note can be edited by its owner.
     */
    @Test
    public void noteCanBeEdited() throws Exception {
        final String name = "name2";
        final String text = "text2";
        
        mockMvcProvider.getMockMvc().perform(post(uri)
                .param("name", name)
                .param("text", text)
                .with(csrf()))
        
            .andExpect(model().hasNoErrors())
            .andExpect((MvcResult result) -> {
                int id = Integer.parseInt(getPathVariable("id", URITemplates.VIEW_NOTE, result.getResponse().getRedirectedUrl())); 
                Note note = repository.findOne(id);

                assertEquals(name, note.getName());
                assertEquals(text, note.getText());
            });
    }
    
    /**
     * Note can't be edited if required fields are missing.
     */
    @Test
    public void noteCannotBeEditedIfFieldIsMissing() throws Exception {
        mockMvcProvider.getMockMvc().perform(post(uri)
                .param("name", "name2")
                .param("text", "")
                .with(csrf()))
        
            .andExpect(model().attributeHasFieldErrors("note", "text"))
            .andExpect(view().name("note/edit"));
    }

    /**
     * Note can't be edited by not an owner.
     */
    @Test
    public void noteCannotBeEditedByOtherUser() throws Exception {
        final String otherUser = "another@example.net";
        userService.signUp(otherUser, "password");
        
        mockMvcProvider.getMockMvc().perform(post(uri)
                .param("name", "name2")
                .param("text", "text2")
                .with(csrf())
                .with(user(otherUser)))
        
            .andExpect(status().is(403));
        
        assertEquals(NAME, repository.getOne(note.getId()).getName());
    }
    
    /**
     * Note can't be added into another's user pad.
     */
    @Test
    public void noteCannotBeAddedIntoAnotherUserPad() throws Exception {
        final String otherUser = "another@example.net";
        userService.signUp(otherUser, "password");
        
        final Pad pad = padService.buildPad();
        pad.setName("name");
        padService.savePad(pad);
        
        mockMvcProvider.getMockMvc().perform(post(uri)
                .param("name", "name")
                .param("text", "text")
                .param("pad", pad.getId().toString())
                .with(csrf())
                .with(user(otherUser)))
        
            .andExpect(status().is(403));
        
        assertNull(repository.getOne(note.getId()).getPad());
    }

}
