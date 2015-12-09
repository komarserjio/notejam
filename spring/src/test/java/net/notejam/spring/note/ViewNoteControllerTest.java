package net.notejam.spring.note;

import static net.notejam.spring.test.UriUtil.buildUri;
import static org.springframework.security.test.web.servlet.request.SecurityMockMvcRequestPostProcessors.user;
import static org.springframework.test.web.servlet.request.MockMvcRequestBuilders.get;
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

import net.notejam.spring.URITemplates;
import net.notejam.spring.note.controller.ViewNoteController;
import net.notejam.spring.test.IntegrationTest;
import net.notejam.spring.test.MockMvcProvider;
import net.notejam.spring.user.SignedUpUserProvider;
import net.notejam.spring.user.UserService;

/**
 * An integration test for the {@link ViewNoteController}.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@IntegrationTest
@RunWith(SpringJUnit4ClassRunner.class)
@WithMockUser(SignedUpUserProvider.EMAIL)
public class ViewNoteControllerTest {

    @Rule
    @Autowired
    public MockMvcProvider mockMvcProvider;
    
    @Rule
    @Autowired
    public SignedUpUserProvider userProvider;
    
    @Autowired
    private UserService userService;
    
    @Autowired
    private NoteService service;
    
    private Note note;
    
    /**
     * The edit note uri.
     */
    private String uri;
    
    @Before
    public void setNote() {
        note = service.buildNote(null);
        note.setName("name");
        note.setText("text");
        service.saveNote(note, null);
    }
    
    @Before
    public void setUri() {
        uri = buildUri(URITemplates.VIEW_NOTE, note.getId());
    }

    /**
     * Note can be viewed by its owner.
     */
    @Test
    public void noteCanBeViewed() throws Exception {
        mockMvcProvider.getMockMvc().perform(get(uri))
            .andExpect(model().hasNoErrors())
            .andExpect(status().is2xxSuccessful())
            .andExpect(view().name("note/view"));
    }
    
    /**
     * Note can't be viewed by not an owner.
     */
    @Test
    public void noteCannotBeViewedByOtherUser() throws Exception {
        final String otherUser = "another@example.net";
        userService.signUp(otherUser, "password");
        
        mockMvcProvider.getMockMvc().perform(get(uri)
                .with(user(otherUser)))
            .andExpect(status().is(403));
    }
    
}
