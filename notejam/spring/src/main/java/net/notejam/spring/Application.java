package net.notejam.spring;

import java.util.Locale;
import java.util.concurrent.Executor;

import org.springframework.beans.factory.annotation.Value;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.boot.orm.jpa.EntityScan;
import org.springframework.context.MessageSource;
import org.springframework.context.NoSuchMessageException;
import org.springframework.context.annotation.AdviceMode;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.context.annotation.EnableAspectJAutoProxy;
import org.springframework.context.annotation.aspectj.EnableSpringConfigured;
import org.springframework.core.convert.ConversionService;
import org.springframework.core.convert.support.DefaultConversionService;
import org.springframework.core.env.PropertySource;
import org.springframework.data.jpa.convert.threeten.Jsr310JpaConverters;
import org.springframework.scheduling.annotation.EnableAsync;
import org.springframework.scheduling.annotation.EnableScheduling;
import org.springframework.scheduling.concurrent.ThreadPoolTaskExecutor;
import org.springframework.web.servlet.LocaleResolver;
import org.springframework.web.servlet.i18n.AcceptHeaderLocaleResolver;

import net.notejam.spring.error.UnsupportedLocaleException;
import net.notejam.spring.helper.converter.StringToPeriodConverter;

/**
 * Configures the Spring framework.
 *
 * @author markus@malkusch.de
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 */
@SpringBootApplication
@EnableSpringConfigured
@EntityScan(basePackageClasses = { Application.class, Jsr310JpaConverters.class })
@EnableAspectJAutoProxy
public class Application {

    /**
     * Configures concurrency.
     *
     * @author markus@malkusch.de
     * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
     */
    @EnableAsync(mode = AdviceMode.ASPECTJ)
    @Configuration
    @EnableScheduling
    public static class AsyncConfiguration {

        /**
         * The queue capacity.
         */
        @Value("${async.queueCapacity}")
        private int queueCapacity;

        /**
         * The mail sending thread.
         *
         * @return The mail executor.
         */
        @Bean
        public Executor mailExecutor() {
            ThreadPoolTaskExecutor executor = new ThreadPoolTaskExecutor();
            executor.setCorePoolSize(1);
            executor.setMaxPoolSize(1);
            executor.setQueueCapacity(queueCapacity);
            executor.setThreadPriority(Thread.MIN_PRIORITY);
            executor.initialize();
            return executor;
        }

    }

    /**
     * Starts the application.
     *
     * @param args
     *            The commandline arguments.
     */
    public static void main(final String[] args) {
        SpringApplication.run(Application.class, args);
    }

    /**
     * Provides the locale resolver.
     *
     * @param messageSource
     *            The messageSource
     * @return The locale resolver.
     * @throws UnsupportedLocaleException
     *             The JVM's default locale does not support any of the
     *             {@link MessageSource} languages.
     */
    @Bean
    public LocaleResolver localeResolver(final MessageSource messageSource) throws UnsupportedLocaleException {
        checkDefaultLocale(messageSource);
        return new AcceptHeaderLocaleResolver();
    }

    /**
     * Checks if the default locale is supported by the messageSource.
     *
     * @param messageSource
     *            The message source
     * @throws UnsupportedLocaleException
     *             The JVM's default locale does not support any of the
     *             {@link MessageSource} languages.
     */
    private static void checkDefaultLocale(final MessageSource messageSource) throws UnsupportedLocaleException {
        try {
            messageSource.getMessage("bootstrap.locale", null, Locale.getDefault());

        } catch (NoSuchMessageException e) {
            throw new UnsupportedLocaleException(String.format(
                    "The JVM runs with the locale %s. This locale is not supported by this application. Please start the JVM with a supported locale, e.g. en.",
                    Locale.getDefault()), e);
        }
    }

    /**
     * The conversion service.
     *
     * The conversion service helps to convert strings from e.g. a
     * {@link PropertySource} into other types.
     *
     * @return The conversion service.
     */
    @Bean
    public ConversionService conversionService() {
        DefaultConversionService service = new DefaultConversionService();
        service.addConverter(new StringToPeriodConverter());
        return service;
    }

}
