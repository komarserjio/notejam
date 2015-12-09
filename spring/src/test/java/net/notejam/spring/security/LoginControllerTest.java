package net.notejam.spring.security;

import static org.springframework.security.test.web.servlet.request.SecurityMockMvcRequestBuilders.formLogin;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.redirectedUrl;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.redirectedUrlPattern;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.status;

import org.junit.Rule;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.test.context.junit4.SpringJUnit4ClassRunner;

import net.notejam.spring.URITemplates;
import net.notejam.spring.test.IntegrationTest;
import net.notejam.spring.test.MockMvcProvider;
import net.notejam.spring.user.SignedUpUserProvider;

/**
 * An integration test for the {@link LoginController}.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@IntegrationTest
@RunWith(SpringJUnit4ClassRunner.class)
public class LoginControllerTest {

    @Rule
    @Autowired
    public MockMvcProvider mockMvcProvider;

    @Rule
    @Autowired
    public SignedUpUserProvider userProvider;
    
    /**
     * User can successfully sign in.
     */
    @Test
    public void userCanSignIn() throws Exception {
        mockMvcProvider.getMockMvc().perform(
                formLogin(URITemplates.SIGNIN)
                    .user(SignedUpUserProvider.EMAIL)
                    .password(SignedUpUserProvider.PASSWORD))

            .andExpect(status().is3xxRedirection())
            .andExpect(redirectedUrl("/"));
    }

    /**
     * User can't sign in if required fields are missing.
     */
    @Test
    public void userCannotSignInIfFieldsAreMissing() throws Exception {
        mockMvcProvider.getMockMvc().perform(
                formLogin(URITemplates.SIGNIN)
                    .user(SignedUpUserProvider.EMAIL)
                    .password(null))

            .andExpect(status().is3xxRedirection())
            .andExpect(redirectedUrlPattern(URITemplates.SIGNIN + "*"));
    }

    /**
     * User can't sign in if credentials are wrong.
     */
    @Test
    public void userCannotSignInWithWrongPassword() throws Exception {
        mockMvcProvider.getMockMvc().perform(
                formLogin(URITemplates.SIGNIN)
                    .user(SignedUpUserProvider.EMAIL)
                    .password(SignedUpUserProvider.PASSWORD + "wrong"))

            .andExpect(status().is3xxRedirection())
            .andExpect(redirectedUrlPattern(URITemplates.SIGNIN + "*"));
    }

}
