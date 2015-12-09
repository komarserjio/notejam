package net.notejam.spring.test;

import static org.springframework.test.util.AssertionErrors.assertEquals;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.status;

import java.net.URI;
import java.util.Map;

import org.springframework.test.web.servlet.MvcResult;
import org.springframework.test.web.servlet.ResultMatcher;
import org.springframework.util.AntPathMatcher;
import org.springframework.web.util.UriComponents;
import org.springframework.web.util.UriComponentsBuilder;

import net.notejam.spring.URITemplates;

/**
 * URI test utility.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
public class UriUtil {

    /**
     * Extracts a path variable for a URI template from an actual URI.
     * 
     * @param name
     *            The path variable
     * @param template
     *            The URI template
     * @param uri
     *            The uri
     * 
     * @return The extracted variable
     */
    public static String getPathVariable(String name, String template, String uri) {
        String noQueryUri = UriComponentsBuilder.fromUriString(uri).replaceQuery(null).toUriString();

        AntPathMatcher pathMatcher = new AntPathMatcher();
        Map<String, String> variables = pathMatcher.extractUriTemplateVariables(template, noQueryUri);
        return variables.get(name);
    }

    /**
     * Build and expand an URI template.
     * 
     * @param template
     *            The URI template
     * @param variables
     *            The URI template variables
     * @return The URI
     */
    public static String buildUri(final String template, final Object... variables) {
        final UriComponents components = UriComponentsBuilder.fromUriString(template).buildAndExpand(variables);
        return components.toUriString();
    }

    /**
     * Asserts the request was redirected to the authentication URI.
     * 
     * @return The result matcher.
     */
    public static ResultMatcher redirectToAuthentication() {
        return (MvcResult result) -> {
            status().is3xxRedirection();
            String path = new URI(result.getResponse().getRedirectedUrl()).getPath();
            assertEquals("Redirected URL", URITemplates.SIGNIN, path);
        };
    }

}
