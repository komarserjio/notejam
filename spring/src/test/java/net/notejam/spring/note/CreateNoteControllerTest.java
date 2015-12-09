package net.notejam.spring.note;

import static net.notejam.spring.test.UriUtil.getPathVariable;
import static net.notejam.spring.test.UriUtil.redirectToAuthentication;
import static org.hamcrest.Matchers.empty;
import static org.junit.Assert.assertEquals;
import static org.junit.Assert.assertNull;
import static org.junit.Assert.assertThat;
import static org.springframework.security.test.web.servlet.request.SecurityMockMvcRequestPostProcessors.csrf;
import static org.springframework.security.test.web.servlet.request.SecurityMockMvcRequestPostProcessors.user;
import static org.springframework.test.web.servlet.request.MockMvcRequestBuilders.post;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.model;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.status;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.view;

import org.junit.Rule;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.test.context.support.WithMockUser;
import org.springframework.test.context.junit4.SpringJUnit4ClassRunner;
import org.springframework.test.web.servlet.MvcResult;

import net.notejam.spring.URITemplates;
import net.notejam.spring.note.controller.CreateNoteController;
import net.notejam.spring.pad.Pad;
import net.notejam.spring.pad.PadService;
import net.notejam.spring.test.IntegrationTest;
import net.notejam.spring.test.MockMvcProvider;
import net.notejam.spring.user.SignedUpUserProvider;
import net.notejam.spring.user.UserService;

/**
 * An integration test for the {@link CreateNoteController}.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@IntegrationTest
@RunWith(SpringJUnit4ClassRunner.class)
public class CreateNoteControllerTest {

    @Autowired
    private UserService userService;
    
    @Autowired
    private PadService padService;
    
    @Autowired
    private NoteRepository repository;
    
    @Rule
    @Autowired
    public MockMvcProvider mockMvcProvider;
    
    @Rule
    @Autowired
    public SignedUpUserProvider userProvider;

    /**
     * Note can be successfully created.
     */
    @Test
    @WithMockUser(SignedUpUserProvider.EMAIL)
    public void noteCanBeCreated() throws Exception {
        final String name = "name";
        final String text = "text";
        
        mockMvcProvider.getMockMvc().perform(post(URITemplates.CREATE_NOTE)
                .param("name", name)
                .param("text", text)
                .with(csrf()))
        
            .andExpect(model().hasNoErrors())
            .andExpect((MvcResult result) -> {
                int id = Integer.parseInt(getPathVariable("id", URITemplates.VIEW_NOTE, result.getResponse().getRedirectedUrl())); 
                Note note = repository.findOne(id);

                assertEquals(name, note.getName());
                assertEquals(text, note.getText());
                assertEquals(SignedUpUserProvider.EMAIL, note.getUser().getEmail());
                assertNull(note.getPad());
            });
    }
    
    /**
     * Note can't be created by anonymous user.
     */
    @Test
    public void noteCannotBeCreatedByAnonymous() throws Exception {
        mockMvcProvider.getMockMvc().perform(post(URITemplates.CREATE_NOTE)
                .param("name", "name")
                .param("text", "text")
                .with(csrf()))
        
            .andExpect(redirectToAuthentication());
        
        assertThat(repository.findAll(), empty());
    }
    
    /**
     * Note can't be created if required fields are missing.
     */
    @Test
    @WithMockUser(SignedUpUserProvider.EMAIL)
    public void noteCannotBeCreatedIfFieldsAreMissing() throws Exception {
        mockMvcProvider.getMockMvc().perform(post(URITemplates.CREATE_NOTE)
                .param("text", "text")
                .with(csrf()))
        
            .andExpect(model().attributeHasFieldErrors("note", "name"))
            .andExpect(view().name("note/create"));
        
        assertThat(repository.findAll(), empty());
    }
    
    /**
     * Note can't be added into another's user pad.
     */
    @Test
    @WithMockUser(SignedUpUserProvider.EMAIL)
    public void noteCannotBeAddedIntoAnotherUserPad() throws Exception {
        final String otherUser = "another@example.net";
        userService.signUp(otherUser, "password");
        
        final Pad pad = padService.buildPad();
        pad.setName("name");
        padService.savePad(pad);
        
        mockMvcProvider.getMockMvc().perform(post(URITemplates.CREATE_NOTE)
                .param("name", "name")
                .param("text", "text")
                .param("pad", pad.getId().toString())
                .with(csrf())
                .with(user(otherUser)))
        
            .andExpect(status().is(403));
        
        assertThat(repository.findAll(), empty());
    }

}
