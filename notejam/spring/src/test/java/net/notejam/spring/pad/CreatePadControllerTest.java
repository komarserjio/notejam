package net.notejam.spring.pad;

import static net.notejam.spring.test.UriUtil.getPathVariable;
import static org.hamcrest.Matchers.empty;
import static org.junit.Assert.assertEquals;
import static org.junit.Assert.assertThat;
import static org.springframework.security.test.web.servlet.request.SecurityMockMvcRequestPostProcessors.csrf;
import static org.springframework.test.web.servlet.request.MockMvcRequestBuilders.post;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.model;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.view;

import org.junit.Rule;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.test.context.support.WithMockUser;
import org.springframework.test.context.junit4.SpringJUnit4ClassRunner;
import org.springframework.test.web.servlet.MvcResult;

import net.notejam.spring.URITemplates;
import net.notejam.spring.pad.controller.CreatePadController;
import net.notejam.spring.test.IntegrationTest;
import net.notejam.spring.test.MockMvcProvider;
import net.notejam.spring.user.SignedUpUserProvider;

/**
 * An integration test for the {@link CreatePadController}.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@IntegrationTest
@RunWith(SpringJUnit4ClassRunner.class)
@WithMockUser(SignedUpUserProvider.EMAIL)
public class CreatePadControllerTest {

    @Rule
    @Autowired
    public MockMvcProvider mockMvcProvider;
    
    @Rule
    @Autowired
    public SignedUpUserProvider userProvider;
    
    @Autowired
    private PadRepository repository;
    
    /**
     * Pad can be successfully created.
     */
    @Test
    public void padCanBeCreated() throws Exception {
        final String name = "name";
        
        mockMvcProvider.getMockMvc().perform(post(URITemplates.CREATE_PAD)
                .param("name", name)
                .with(csrf()))
        
            .andExpect(model().hasNoErrors())
            .andExpect((MvcResult result) -> {
                int id  = Integer.parseInt(getPathVariable("id", URITemplates.VIEW_PAD, result.getResponse().getRedirectedUrl())); 
                Pad pad = repository.findOne(id);

                assertEquals(name, pad.getName());
                assertEquals(SignedUpUserProvider.EMAIL, pad.getUser().getEmail());
            });
    }
    
    /**
     * Pad can't be created if required fields are missing.
     */
    @Test
    public void padCannotBeCreatedIfFieldsAreMissing() throws Exception {
        mockMvcProvider.getMockMvc().perform(post(URITemplates.CREATE_PAD)
                .with(csrf()))
        
            .andExpect(model().attributeHasFieldErrors("pad", "name"))
            .andExpect(view().name("pad/create"));
        
        assertThat(repository.findAll(), empty());
    }
    
}
