package net.notejam.spring.test;

import static org.springframework.security.test.web.servlet.setup.SecurityMockMvcConfigurers.springSecurity;
import static org.springframework.test.web.servlet.setup.MockMvcBuilders.webAppContextSetup;

import org.junit.rules.ExternalResource;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;
import org.springframework.test.web.servlet.MockMvc;
import org.springframework.web.context.WebApplicationContext;

/**
 * A rule for providing a {@link MockMvc} object.
 * 
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Component
public class MockMvcProvider extends ExternalResource {

    @Autowired
    private WebApplicationContext context;
    
    private MockMvc mockMvc;
    
    @Override
    protected void before() {
        this.mockMvc = webAppContextSetup(context).apply(springSecurity()).build();
    }
    
    /**
     * Returns the {@link MockMvc} object.
     * 
     * @return The MockMvc object.
     */
    public MockMvc getMockMvc() {
        return mockMvc;
    }
    
}
