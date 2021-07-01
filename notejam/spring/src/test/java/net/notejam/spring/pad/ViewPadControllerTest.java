package net.notejam.spring.pad;

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
import net.notejam.spring.pad.controller.ViewPadNotesController;
import net.notejam.spring.test.IntegrationTest;
import net.notejam.spring.test.MockMvcProvider;
import net.notejam.spring.user.SignedUpUserProvider;
import net.notejam.spring.user.UserService;

/**
 * An integration test for the {@link ViewPadNotesController}.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@IntegrationTest
@RunWith(SpringJUnit4ClassRunner.class)
@WithMockUser(SignedUpUserProvider.EMAIL)
public class ViewPadControllerTest {

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
        
        uri = buildUri(URITemplates.VIEW_PAD, pad.getId());
    }
    
    /**
     * Pad can be viewed by its owner.
     */
    @Test
    public void padCanBeViewed() throws Exception {
        mockMvcProvider.getMockMvc().perform(get(uri))
            .andExpect(model().hasNoErrors())
            .andExpect(status().is2xxSuccessful())
            .andExpect(view().name("notes"));
    }
    
    /**
     * pad can't be viewed by not an owner
     */
    @Test
    public void padCannotBeViewedByOtherUser() throws Exception {
        final String otherUser = "another@example.net";
        userService.signUp(otherUser, "password");
        
        mockMvcProvider.getMockMvc().perform(get(uri)
                .with(user(otherUser)))
            .andExpect(status().is(403));
    }
    
}
