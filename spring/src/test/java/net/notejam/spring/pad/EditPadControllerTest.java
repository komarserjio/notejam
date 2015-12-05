package net.notejam.spring.pad;

import static net.notejam.spring.test.UriUtil.buildUri;
import static net.notejam.spring.test.UriUtil.getPathVariable;
import static org.junit.Assert.assertEquals;
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
import net.notejam.spring.pad.controller.EditPadController;
import net.notejam.spring.test.IntegrationTest;
import net.notejam.spring.test.MockMvcProvider;
import net.notejam.spring.user.SignedUpUserProvider;
import net.notejam.spring.user.UserService;

/**
 * An integration test for the {@link EditPadController}.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@IntegrationTest
@RunWith(SpringJUnit4ClassRunner.class)
@WithMockUser(SignedUpUserProvider.EMAIL)
public class EditPadControllerTest {

    @Rule
    @Autowired
    public MockMvcProvider mockMvcProvider;
    
    @Rule
    @Autowired
    public SignedUpUserProvider userProvider;
    
    @Autowired
    private PadRepository repository;
    
    @Autowired
    private PadService padService;
    
    @Autowired
    private UserService userService;
    
    private Pad pad;
    
    /**
     * The provided pad name.
     */
    private final String NAME = "name";
    
    /**
     * The edit note uri.
     */
    private String uri;
    
    private void setPad() {
        pad = padService.buildPad();
        pad.setName("name");
        padService.savePad(pad);
    }
    
    @Before
    public void setUri() {
        setPad();
        
        uri = buildUri(URITemplates.EDIT_PAD, pad.getId());
    }
    
    /**
     * Pad can be edited by its owner.
     */
    @Test
    public void padCanBeEdited() throws Exception {
        final String name = "name2";
        
        mockMvcProvider.getMockMvc().perform(post(uri)
                .param("name", name)
                .with(csrf()))
        
            .andExpect(model().hasNoErrors())
            .andExpect((MvcResult result) -> {
                int id = Integer.parseInt(getPathVariable("id", URITemplates.EDIT_PAD, result.getResponse().getRedirectedUrl())); 
                Pad pad = repository.findOne(id);

                assertEquals(name, pad.getName());
            });
    }
    
    /**
     * Pad can't be edited if required fields are missing.
     */
    @Test
    public void padCannotBeEditedIfFieldIsMissing() throws Exception {
        mockMvcProvider.getMockMvc().perform(post(uri)
                .param("name", "")
                .with(csrf()))
        
            .andExpect(model().attributeHasFieldErrors("pad", "name"))
            .andExpect(view().name("pad/edit"));
    }
    
    /**
     * Pad can't be edited by not an owner.
     */
    @Test
    public void padCannotBeEditedByOtherUser() throws Exception {
        final String otherUser = "another@example.net";
        userService.signUp(otherUser, "password");
        
        mockMvcProvider.getMockMvc().perform(post(uri)
                .param("name", "name2")
                .with(user(otherUser))
                .with(csrf()))
        
            .andExpect(status().is(403));
        
        assertEquals(NAME, repository.getOne(pad.getId()).getName());
    }
    
}
