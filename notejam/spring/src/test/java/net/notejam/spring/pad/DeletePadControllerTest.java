package net.notejam.spring.pad;

import static net.notejam.spring.test.UriUtil.buildUri;
import static org.junit.Assert.assertNotNull;
import static org.junit.Assert.assertNull;
import static org.springframework.security.test.web.servlet.request.SecurityMockMvcRequestPostProcessors.csrf;
import static org.springframework.security.test.web.servlet.request.SecurityMockMvcRequestPostProcessors.user;
import static org.springframework.test.web.servlet.request.MockMvcRequestBuilders.post;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.status;

import org.junit.Before;
import org.junit.Rule;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.test.context.support.WithMockUser;
import org.springframework.test.context.junit4.SpringJUnit4ClassRunner;

import net.notejam.spring.URITemplates;
import net.notejam.spring.pad.controller.DeletePadController;
import net.notejam.spring.test.IntegrationTest;
import net.notejam.spring.test.MockMvcProvider;
import net.notejam.spring.user.SignedUpUserProvider;
import net.notejam.spring.user.UserService;

/**
 * An integration test for the {@link DeletePadController}.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@IntegrationTest
@RunWith(SpringJUnit4ClassRunner.class)
@WithMockUser(SignedUpUserProvider.EMAIL)
public class DeletePadControllerTest {

    @Rule
    @Autowired
    public MockMvcProvider mockMvcProvider;
    
    @Rule
    @Autowired
    public SignedUpUserProvider userProvider;
    
    @Autowired
    private PadService padService;
    
    @Autowired
    private UserService userService;
    
    @Autowired
    private PadRepository repository;
    
    private Pad pad;
    
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
        
        uri = buildUri(URITemplates.DELETE_PAD, pad.getId());
    }
    
    /**
     * Pad can be deleted by its owner.
     */
    @Test
    public void padCanBeDeleted() throws Exception {
        mockMvcProvider.getMockMvc().perform(post(uri)
                .with(csrf()))

            .andExpect(status().is3xxRedirection());
        
        assertNull(repository.findOne(pad.getId()));
    }
    
    /**
     * Pad can't be deleted by not an owner.
     */
    @Test
    public void padCannotBeDeletedByOtherUser() throws Exception {
        final String otherUser = "another@example.net";
        userService.signUp(otherUser, "password");
        
        mockMvcProvider.getMockMvc().perform(post(uri)
                .with(csrf())
                .with(user(otherUser)))

            .andExpect(status().is(403));
        
        assertNotNull(repository.findOne(pad.getId()));
    }
    
}
