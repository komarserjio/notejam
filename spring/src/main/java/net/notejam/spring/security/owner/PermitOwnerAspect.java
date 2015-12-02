package net.notejam.spring.security.owner;

import java.util.Optional;

import org.aspectj.lang.JoinPoint;
import org.aspectj.lang.annotation.AfterReturning;
import org.aspectj.lang.annotation.Aspect;
import org.aspectj.lang.annotation.Before;
import org.aspectj.lang.annotation.Pointcut;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Configurable;
import org.springframework.security.access.AccessDeniedException;

import net.notejam.spring.helper.reflection.Annotated;
import net.notejam.spring.helper.reflection.ReflectionUtils;
import net.notejam.spring.user.User;
import net.notejam.spring.user.UserService;

/**
 * Grant access only to the authenticated owner of an object.
 * 
 * @author markus@malkusch.de
 * 
 * @see <a href="bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK">Donations</a>
 * @see Owned
 * @see PermitOwner
 */
@Aspect
@Configurable
public class PermitOwnerAspect {

    /**
     * The user service.
     */
    @Autowired
    private UserService userService;

    /**
     * Sets the user service.
     * 
     * @param userService
     *            The user service
     */
    void setUserService(UserService userService) {
        this.userService = userService;
    }

    @Pointcut("execution(* *(.., @PermitOwner (*), ..))")
    private void restrictOwnedEntities() {
    }

    @Before("net.notejam.spring.security.owner.PermitOwnerAspect.restrictOwnedEntities()")
    public void authorizeCall(JoinPoint joinPoint) {
        for (Annotated<PermitOwner, Owned> annotated : ReflectionUtils
                .<PermitOwner, Owned> getAnnotatedArguments(PermitOwner.class, joinPoint)) {
            if (annotated.getObject() == null) {
                continue;

            }
            authorize(annotated.getObject());

        }
    }

    @Pointcut("execution(@PermitOwner * *(..))")
    private void restrictOwnedResults() {
    }

    @AfterReturning(pointcut = "net.notejam.spring.security.owner.PermitOwnerAspect.restrictOwnedResults()", returning = "entity")
    public void authorizeReturn(Object entity) {
        if (entity instanceof Owned) {
            authorize((Owned) entity);

        } else if (entity instanceof Optional) {
            authorize(((Optional<Owned>) entity).orElse(null));
        }
    }

    private void authorize(Owned owned) {
        if (owned == null) {
            return;
        }

        User user = userService.getAuthenticatedUser();
        if (user == null) {
            throw new AccessDeniedException(String.format("%s needs an authenticated user.", owned));
        }

        if (user.equals(owned.getUser())) {
            return;

        } else {
            throw new AccessDeniedException(String.format("User %s is not allowed to access object of user %s.",
                    user.getId(), owned.getUser().getId()));
        }
    }

}
