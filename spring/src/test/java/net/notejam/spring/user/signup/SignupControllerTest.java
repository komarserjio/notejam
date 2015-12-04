package net.notejam.spring.user.signup;

import static org.junit.Assert.assertFalse;
import static org.springframework.security.test.web.servlet.request.SecurityMockMvcRequestPostProcessors.csrf;
import static org.springframework.security.test.web.servlet.setup.SecurityMockMvcConfigurers.springSecurity;
import static org.springframework.test.web.servlet.request.MockMvcRequestBuilders.post;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.model;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.redirectedUrl;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.view;
import static org.springframework.test.web.servlet.setup.MockMvcBuilders.webAppContextSetup;

import org.junit.Before;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.authentication.AuthenticationManager;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.Authentication;
import org.springframework.test.context.junit4.SpringJUnit4ClassRunner;
import org.springframework.test.context.web.WebAppConfiguration;
import org.springframework.test.web.servlet.MockMvc;
import org.springframework.test.web.servlet.MvcResult;
import org.springframework.web.context.WebApplicationContext;

import net.notejam.spring.URITemplates;
import net.notejam.spring.test.IntegrationTest;
import net.notejam.spring.user.UserService;

/**
 * An integration test for the {@link SignupController}.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@IntegrationTest
@WebAppConfiguration
@RunWith(SpringJUnit4ClassRunner.class)
public class SignupControllerTest {

    @Autowired
    private WebApplicationContext context;

    private MockMvc mockMvc;
    
    @Autowired
    private AuthenticationManager authenticationManager;
    
    @Autowired
    private UserService userService;
    
    @Before
    public void setupMockMvc() {
        this.mockMvc = webAppContextSetup(context).apply(springSecurity()).build();
    }

    /**
     * User can successfully sign up.
     */
    @Test
    public void userCanSuccessfullySignUp() throws Exception {
        final String email    = "test@example.net";
        final String password = "EHKBHHKe";
        
        mockMvc.perform(post(URITemplates.SIGNUP)
                .param("email", email)
                .param("password", password)
                .param("repeatedPassword", password)
                .with(csrf()))

            .andExpect(model().hasNoErrors())
            .andExpect(redirectedUrl("/signin?signup"))
            .andExpect((MvcResult result) -> {
                Authentication request = new UsernamePasswordAuthenticationToken(email, password);
                authenticationManager.authenticate(request);
            });
    }
    
    /**
     * User can't sign up if required fields are missing.
     */
    @Test
    public void userCannotSignUpIfFieldIsMissing() throws Exception {
        final String email    = "test@example.net";
        final String password = "EHKBHHKe";
        
        mockMvc.perform(post(URITemplates.SIGNUP)
                .param("email", email)
                .param("password", password)
                .with(csrf()))
        
            .andExpect(model().attributeHasFieldErrors("user", "repeatedPassword"))
            .andExpect(view().name("user/signup"));

        assertFalse(userService.isEmailRegistered(email));
    }
    
    /**
     * User can't sign up if email is invalid.
     */
    @Test
    public void userCannotSignUpIfEmailIsInvalid() throws Exception {
        final String email    = "invalid";
        final String password = "EHKBHHKe";
        
        mockMvc.perform(post(URITemplates.SIGNUP)
                .param("email", email)
                .param("password", password)
                .param("repeatedPassword", password)
                .with(csrf()))
        
            .andExpect(model().attributeHasFieldErrors("user", "email"))
            .andExpect(view().name("user/signup"));
        
        assertFalse(userService.isEmailRegistered(email));
    }
    
    /**
     * User can't sign up if email already exists.
     */
    @Test
    public void userCannotSignUpIfEmailExists() throws Exception {
        final String email    = "test@example.net";
        final String password = "EHKBHHKe";
        
        userService.signUp(email, "QiXUzGS");
        
        mockMvc.perform(post(URITemplates.SIGNUP)
                .param("email", email)
                .param("password", password)
                .param("repeatedPassword", password)
                .with(csrf()))
        
            .andExpect(model().attributeHasFieldErrors("user", "email"))
            .andExpect(view().name("user/signup"));
    }
    
    /**
     * User can't sign up if passwords do not match
     */
    @Test
    public void userCannotSignUpIfPasswordsDontMatch() throws Exception {
        final String email    = "test@example.net";
        
        mockMvc.perform(post(URITemplates.SIGNUP)
                .param("email", email)
                .param("password", "EHKBHHKe")
                .param("repeatedPassword", "QiXUzGS")
                .with(csrf()))
        
            .andExpect(model().attributeHasFieldErrors("user", "password"))
            .andExpect(view().name("user/signup"));
        
        assertFalse(userService.isEmailRegistered(email));
    }

}
