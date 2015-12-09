package net.notejam.spring.view;

import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;

import net.notejam.spring.view.dialect.NotejamDialect;

/**
 * Configures the view.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@Configuration
public class ViewConfiguration {

    /**
     * Provide the notejam view dialect.
     *
     * @return The notejam dialect.
     */
    @Bean
    public NotejamDialect notejamDialect() {
        return new NotejamDialect();
    }

}
